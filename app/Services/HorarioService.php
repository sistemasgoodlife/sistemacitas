<?php namespace App\Services;

use App\Interfaces\HorarioServiceInterface;
use App\Models\Horarios;
use Carbon\Carbon;

class HorarioService implements HorarioServiceInterface{

    private function getDayFromDate($date){
        $dateCarbon = new Carbon($date);
        $i = $dateCarbon->dayOfWeek;
        $day = ($i==0 ? 6 : $i-1);

        return $day;
    }

    public function getAvailableIntervals($date, $doctorId){
        $horario = Horarios::where('active', true)
            ->where('day', $this->getDayFromDate($date))
            ->where('user_id', $doctorId)
            ->first([
                'morning_start',
                'morning_end',
                'afternoo_start',
                'afternoon_end'
            ]);
        if(!$horario){
            return [];
        }

        $morningIntervalos = $this->getIntervalos(
            $horario->morning_start, $hora->morning_end
        );

        $afternoonIntervalos = $this->getIntervalos(
            $horario->afternoon_start, $hora->afternoon_end
        );

        $data = [];
        $data['morning'] = $morningIntervalos;
        $data['afternoon'] = $afternoonIntervalos;

        return $data;
    }

    private function getIntervalos($start, $end){
        $start = new Carbon($start);
        $end = new Carbon($end);

        $intervalos = [];
        while($start < $end){
            $intervalo = [];
            $intervalo['start'] = $start->format('g:i A');
            $start->addMinutes(30);
            $intervalo['end'] = $start->format('g:i A');
            $intervalos [] = $intervalo;
        }
        return $intervalos;
    }
}