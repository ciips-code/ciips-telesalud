<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicRequest;
use App\Http\Resources\FileResource;
use App\Interfaces\JitsiService;
use App\Models\Videoconsultation;
use App\Models\VideoconsultationChat;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class VideoconsultationController extends Controller
{

    function videoconsultation(Request $request, JitsiService $jitsiService) {

        $vc = Videoconsultation::where('secret', $request->vc)
            ->first();

        if(!$vc) {
            return view('videoconsultation.error', [
                'titulo' => __('controllers.vc_not_found')
            ]);
        }

        if($vc->status == 'Cancelled') {
            return view('videoconsultation.error', [
                'titulo' => __('controllers.vc_cancelled')
            ]);
        }

        if($vc->appointment_date->toImmutable()->subMinutes(10) > CarbonImmutable::now()) {
            return view('videoconsultation.error', [
                'titulo' => __('controllers.vc_not_started'),
                'subtitulo' => __('controllers.vc_start_time', ['date' => $vc->appointment_date->format('d/m/Y'), 'time' => $vc->appointment_date->format('H:i')])
            ]);
        }

        if($vc->expiration_date <= CarbonImmutable::now()) {
            return view('videoconsultation.error', [
                'titulo' => __('controllers.vc_expired')
            ]);
        }

        if($vc->status != 'Valid') {
            return view('videoconsultation.error', [
                'titulo' => __('controllers.vc_finished')
            ]);
        }

        if($request->has('medic')) {
            if($request->medic != $vc->medic_secret) return response(__('controllers.vc_not_found'));
            $esMedico = true;
            $name = $vc->medic_name;
        } else {
            $esMedico = false;
            $name = $vc->patient_name;
        }

        if(!$esMedico && $vc->medic_attendance_date == null) {
            return view('videoconsultation.wait', ['vc' => $vc]);
        }

        $token = $jitsiService->getToken($name, $vc->expiration_date->toImmutable(), $vc->secret, $esMedico);
        $baseUrl = $jitsiService->getBaseUrl();

        return view('videoconsultation.videoconsultation',
            compact('vc', 'esMedico', 'name', 'token', 'baseUrl'));

    }

    public function addChat(MedicRequest $request) {
        $vc = $request->videoconsultation;
        if($vc->isValid()) {
            $chat = VideoconsultationChat::firstOrNew(['videoconsultation_id' => $vc->id]);
            $chat->addChat($request->es_medic ? $vc->medic_name : $vc->patient_name, now(), $request->mensaje);
            $chat->save();
            return $this->success();
        }
        return $this->error(409, __('controllers.vc_expired'));
    }

    public function addFile(Request $request) {
        $val = Validator::make($request->all(), [
            'vc' => 'required',
            'description' => 'required|min:3|max:40',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,bmp,png,doc,docx'
        ]);

        if($val->fails()) {
            return $this->error(400, '', $val->errors());
        }

        $vc = Videoconsultation::where('secret', $request->vc)
            ->first();

        if(!$vc || !$vc->isValid()) return $this->error(404, __('controllers.vc_not_found'));

        if($request->has('medic')) {
            if($request->medic != $vc->medic_secret) return $this->error(404, __('controllers.vc_not_found'));
            $esMedico = true;
        } else {
            $esMedico = false;
        }

        $path = $request->file('file')->store("files/$vc->id");

        $vc->files()->create([
            'description' => $request->description,
            'file_name' => $path,
            'medic' => $esMedico,
        ]);

        return $this->success();
    }

    public function listFiles(Request $request) {
        $vc = Videoconsultation::where('secret', $request->vc)
            ->first();

        if(!$vc) {
            return $this->error(404, __('controllers.vc_not_found'));
        }

        if($vc->isValid()) {
            $files = $vc->files;

            return $this->success([
                'medic' => [
                    'name' => $vc->medic_name,
                    'files' => FileResource::collection($files->where('medic', true))
                ],
                'paciente' => [
                    'name' => $vc->patient_name,
                    'files' => FileResource::collection($files->where('medic', false))
                ],
            ]);
        }
        return $this->error(409, __('controllers.vc_expired'));
    }

    public function saveEvolution(MedicRequest $request) {
        $vc = $request->videoconsultation;
        if($vc->isValid()) {
            $vc->evolution = $request->evolution;
            $vc->save();

            return $this->success();
        }
        return $this->error(409, __('controllers.vc_expired'));
    }

    public function downloadFile($vc, $id) {
        $vc = Videoconsultation::where('secret', $vc)
            ->first();

        if(!$vc) {
            abort(404);
        }

        $file = $vc->files()
            ->where('id', $id)
            ->first();

        if(!$file) {
            abort(404);
        }

        return Storage::download($file->file_name, Str::slug($file->description));
    }

    public function setMedicAttendance(MedicRequest $request) {
        $vc = $request->videoconsultation;
        $vc->medic_attendance_date = now();

        $vc->save();

        notify($vc, 'medic-set-attendance');

        return $this->success();
    }

    public function unsetMedicAttendance(MedicRequest $request) {
        $vc = $request->videoconsultation;
        $vc->medic_attendance_date = null;

        notify($vc, 'medic-unset-attendance');

        $vc->save();

        return $this->success();
    }

    public function setStart(MedicRequest $request) {
        $vc = $request->videoconsultation;
        if(!$vc->isStarted()) {
            $vc->start_date = now();
        }

        $vc->save();

        notify($vc, 'videoconsultation-started');

        return $this->success();
    }

    public function setFinish(MedicRequest $request) {
        $vc = $request->videoconsultation;
        $vc->finish_date = now();
        $vc->status = 'Finished';

        $vc->save();

        notify($vc, 'videoconsultation-finished');

        return $this->success();
    }

    public function checkFinished(Request $request) {
        $vc = Videoconsultation::where('secret', $request->vc)
            ->first();

        if(!$vc) {
            return $this->error(404, __('controllers.vc_not_found'));
        }

        return $this->success(['finished' => $vc->status == 'Finished']);
    }

    function setPatientAttendance(Request $request) {
        $vc = Videoconsultation::where('secret', $request->vc)
            ->first();

        if(!$vc) {
            return $this->error(404, __('controllers.vc_not_found'));
        }

        $vc->patient_attendance_date = now();
        $vc->save();

        notify($vc, 'patient-set-attendance');

        return $this->success();
    }


}
