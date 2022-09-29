<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'scheduled_date',
        'sheduled_time',
        'type',
        'doctor_id',
        'patient_id',
        'specialty_id'
    ];
}
