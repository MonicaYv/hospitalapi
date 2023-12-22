<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Hospital;
use App\Models\Disease;

class PatientRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'hospital_id',
        'disease_id',
        'admitted',
        'discharged'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }
}
