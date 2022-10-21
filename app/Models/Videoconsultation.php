<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videoconsultation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['appointment_date', 'expiration_date', 'medic_attendance_date', 'patient_attendance_date', 'start_date', 'finish_date'];

    protected $casts = [
        'extra' => 'array',
    ];

    public function isValid() {

        $now = now();

        return $this->status == 'Valid'
            && $this->appointment_date->subMinutes(10) <= $now
            && $this->expiration_date >= $now;

    }

    public function isStarted() {
        return $this->start_date != null;
    }

    public function isMedicPresent() {
        return $this->medic_attendance_date != null;
    }

    public function chat() {
        return $this->hasOne(VideoconsultationChat::class, 'videoconsultation_id');
    }

    public function files() {
        return $this->hasMany(VideoconsultationFile::class, 'videoconsultation_id');
    }
}
