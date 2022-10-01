<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelledAppointment extends Model
{
    use HasFactory;

    public function cancelled_by(){
        return $this->belongsTo(User::class);
    }
}
