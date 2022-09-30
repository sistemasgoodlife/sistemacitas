<?php

namespace App\Http\Controllers;

use App\Interfaces\HorarioServiceInterface;
use App\Models\Specialty;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{

    public function index(){
        $confirmedAppointments = Appointment::all()
            ->where('status', 'Confirmada')
            ->where('patient_id', auth()->id());
        $pendingAppointments = Appointment::all()
            ->where('status', 'Reservada')
            ->where('patient_id', auth()->id());
        $oldAppointments = Appointment::all()
            ->whereIn('status', ['Atendido', 'Cancelado'])
            ->where('patient_id', auth()->id());
        return view('appointments.index', compact('confirmedAppointments', 'pendingAppointments', 'oldAppointments'));
    }

    public function create(HorarioServiceInterface $horarioServiceInterface){
        $specialties = Specialty::all();

        $specialtyId = old('specialty_id');
        if($specialtyId){
            $specialty = Specialty::find($specialtyId);
            $doctors = $specialty->users;
        } else{
            $doctors = collect();
        }

        $date = old('scheduled_date');
        $doctorId = old('doctor_id');
        if($date && $doctorId){
            $intervals = $horarioServiceInterface->getAvailableIntervals($date, $doctorId);
        }else {
            $intervals = null;
        }

        return view('appointments.create', compact('specialties', 'doctors', 'intervals'));
    }

    public function store(Request $request, HorarioServiceInterface $horarioServiceInterface){

        $rules = [
            'scheduled_time' => 'required',
            'type' => 'required',
            'doctor_id' => 'exists:users,id',
            'especialty_id' => 'exists:specialties,id'
        ];

        $messages = [
            'scheduled_time.required' => 'Debe seleccionar una hora valida para su cita',
            'type.required' => 'Debe seleccionar el tipo de consulta'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->after(function ($validator) use ($request, $horarioServiceInterface) {

            $date = $request->input('scheduled_date');
            $doctorId = $request->input('doctor_id');
            $scheduled_time = $request->input('scheduled_time');
            if($date && $doctorId && $scheduled_time){
                $start = new Carbon($scheduled_time);
            }else {
                return;
            }

            if (!$horarioServiceInterface->isAvailableInterval($date, $doctorId, $start)) {
                $validator->errors()->add(
                    'available_time', 'La hora seleccionada ya se encuentra seleccionada por otro paciente'
                );
            }
        });

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = $request->only([
            'scheduled_date',
            'sheduled_time',
            'type',
            'doctor_id',
            'specialty_id'
        ]);
        $data['patient_id'] = auth()->id();

        $carbonTime = Carbon::createFromFormat('g:i A', $data['scheduled_time']);
        $data['scheduled_time'] = $carbonTime->format('H:i:s');

        Appointment::create($data);

        $notification = 'La cita se ha realizado correctamente';
        return back()->with(compact('notification'));
    }

    public function cancel(Appointment $appointment){
        $appointment->status = 'Cancelada';
        $appointment->save();
        $notification = 'La cita se ha cancelado correctamente.';

        return back()->with(compact('notification'));
    }
}
