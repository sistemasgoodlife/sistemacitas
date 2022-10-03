<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function appointments(){

           $monthCounts = Appointment::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(1) as count'))
                ->groupBy('month')
                ->get()
                ->toArray();
            $counts = array_fill(0, 12, 0);
            foreach($monthCounts as $monthCount){
                $index = $monthCount['month']-1;
                $counts[$index] = $monthCount['count'];
            }

        return view('charts.appointments', compact('counts'));
    }

    public function doctors(){
        return view('charts.doctors');
    }

    public function doctorsJson(){
        $doctors = User::doctors()
            ->select('name')
            ->withCount('asAttendedAppointments', 'asCancellAppointments')
            ->orderBy('cancell_appointments_count', 'desc')
            ->take(5)
            ->get();

        $data = [];
        $data['categories'] = $doctors->pluck('name');

        $series = [];
        $series1['name'] = ['Citas atendidas'];
        $series1['data'] = $doctors->pluck('attended_appointments_count');
        $series2['name'] = ['Citas atendidas'];
        $series2['data'] = $doctors->pluck('cancell_appointments_count');

        $series[] = $series1;
        $series[] = $series2;
        $data['series'] = $series;

        return $data;
    }
}
