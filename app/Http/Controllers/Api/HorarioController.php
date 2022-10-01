<?php

namespace App\Http\Controllers\Api;

use App\Interfaces\HorarioServiceInterface;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Horarios;

class HorarioController extends Controller
{
    public function hours(Request $request, HorarioServiceInterface $horarioServiceInterface){

        $rules = [
            'date' => 'required|date_dormat:"Y-m-d"',
            'doctor_id' => 'required|exists:users,id'
        ];
        $this->validate($request, $rules);

        $date = $request->input('date');
        
        $doctorId = $request->input('doctor_id');

        return $horarioServiceInterface->getAvailableIntervals($date, $doctorId);
    }
}
