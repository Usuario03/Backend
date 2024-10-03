<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Histories extends Model
{
    protected $fillable = [
        'patient_id',
        'professional_id',
        'patient_info',
        'date_time',
        'consecutive_number',
        'patient_status',
        'medical_history',
        'final_evolution',
        'professional_concept',
        'recommendations',
        'assistance',
    ];

    // Relación con la tabla de pacientes
    public function patientOne()
    {
        return $this->belongsTo(User::class, 'patient_id')->select('identification_number', 'first_name', 'last_name');
    }

    // Relación con la tabla de profesionales
    public function professionalOne()
    {
        return $this->belongsTo(User::class, 'professional_id')->select('identification_number', 'first_name', 'last_name');
    }
}
