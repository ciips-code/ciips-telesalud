<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicRequest;
use App\Models\Videoconsultation;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createVideoconsultation(Request $request)
    {
        $val = Validator::make($request->all(), [
            'appointment_date' => 'required|date',
            'days_before_expiration' => 'required|integer|min:1',
            'medic_name' => 'required',
            'patient_name' => 'required',
            'id_turno' => 'integer',
            'extra' => 'array',
        ]);

        if($val->fails()) {
            return $this->error(400, '', $val->errors());
        }

        $secret = sha1(Str::random(8) . $request->appointment_date . $request->medic_name . $request->patient_name);
        $medicSecret = Str::random(10);

        $appointmentDate = new CarbonImmutable($request->appointment_date);
        $expirationDate = $appointmentDate->addDays($request->days_before_expiration);

        $vc = new Videoconsultation([
            'secret' => $secret,
            'medic_secret' => $medicSecret,
            'appointment_date' => $appointmentDate,
            'expiration_date' => $expirationDate,
            'patient_id' => $request->patient_id,
            'patient_number' => $request->patient_number,
            'patient_name' => $request->patient_name,
            'medic_name' => $request->medic_name,
            'extra' => $request->extra,
        ]);

        $vc->save();

        return $this->success([
            'id' => $vc->secret,
            'valid_from' => $appointmentDate->subMinutes(10),
            'valid_to' => $expirationDate,
            'patient_url' => route('videoconsultation', ['vc' => $secret]),
            'medic_url' => route('videoconsultation', ['vc' => $secret, 'medic' => $medicSecret]),
            'data_url' => route('videoconsultation_data', ['vc' => $secret, 'medic' => $medicSecret]),
        ]);
    }

    public function getVideoconsultationData(MedicRequest $request) {

        $vc = $request->videoconsultation;

        if($vc->status == 'Cancelled'
            || ($vc->status == 'Valid' && now() < $vc->expiration_date)) {
            return $this->error(409, __('controllers.vc_not_finished'));
        } else {

            $files = $vc->files->map(function($item, $key) {
                return collect([
                    'type' => $item->medic ? 'medic' : 'paciente',
                    'description' => $item->description,
                    'file' => base64_encode(Storage::get($item->file_name))
                ]);
            })->groupBy('type');

            return $this->success([
                'id' => $vc->secret,
                'appointment_date' => $vc->appointment_date,
                'expiration_date' => $vc->expiration_date,
                'medic_attendance_date' => $vc->medic_attendance_date,
                'patient_attendance_date' => $vc->patient_attendance_date,
                'start_date' => $vc->start_date,
                'finish_date' => $vc->finish_date,
                'patient_id' => $vc->patient_id,
                'patient_number' => $vc->patient_number,
                'evolution' => $vc->evolution,
                'chat' => $vc?->chat?->chat,
                'extra' => $vc->extra,
                'files' => $files,
            ]);

        }

    }


}
