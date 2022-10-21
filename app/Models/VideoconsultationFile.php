<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoconsultationFile extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'medic' => 'boolean',
    ];

    public function videoconsultation() {
        return $this->belongsTo(Videoconsultation::class, 'videoconsultation_id');
    }
}
