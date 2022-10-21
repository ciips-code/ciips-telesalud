<?php

namespace App\Http\Requests;

use App\Models\Videoconsultation;
use Illuminate\Foundation\Http\FormRequest;

class MedicRequest extends FormRequest
{

    public $videoconsultation;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $vc = Videoconsultation::where('secret', $this->vc)
            ->where('medic_secret', $this->medic)
            ->first();

        if($vc) {
            $this->videoconsultation = $vc;
            return true;
        }
        else return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'vc' => 'required',
            'medic' => 'required'
        ];
    }
}
