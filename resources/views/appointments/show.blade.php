@extends('layouts.panel')

@section('content')

          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Cita #{{ $appointment->id }}</h3>
                </div>
                
                <div class="col text-right">
                  <a href="{{ url('/miscitas') }}" class="btn btn-sm btn-success"> 
                    <i class="fas fa-chevron-left"></i>
                    Atrás</a>
                </div>

              </div>
            </div>
            <div class="card-body">
                <ul>
                    <dd>
                        <strong>Fecha: </strong>{{ $appointment->scheduled_date }}
                    </dd>
                    <dd>
                        <strong>Hora de atención: </strong>{{ $appointment->scheduled_time_12 }}
                    </dd>
                    @if ($role == 'paciente' || $role == 'admin')
                        <dd>
                            <strong>Doctor: </strong> {{$appointment->doctor->name}}
                        </dd>
                    @elseif ($role == 'doctor' || $role == 'admin')
                        <dd>
                            <strong>Paciente: </strong> {{$appointment->patient->name}}
                        </dd>
                    @endif
                    <dd>
                        <strong>Especialidad: </strong>{{ $appointment->specialty->name }}
                    </dd>
                    <dd>
                        <strong>Tipo de consulta: </strong>{{ $appointment->type }}
                    </dd>
                    <dd>
                        <strong>Estado: </strong>
                        @if ($appointment->status == 'Cancelada')
                            <span class="badge badge-danger">Cancelada</span>
                        @else
                            <span class="badge badge-primary">{{ $appointment->status }}</span>
                        @endif
                    </dd>
                </ul>

                @if ($appointment->status == 'Cancelada')
                    <div class="alert bg-lite text-primary">
                        <h3>Detalles de la cancelación</h3>
                        @if ($appointment->cancellation)
                        <ul>
                            <li>
                                <strong>Fecha de cancelación: </strong>
                                {{ $appointment->cancellation->created_at }}
                            </li>
                            <li>
                                <strong>La cita fue cancelada por: </strong>
                                {{ $appointment->cancellation->cancelled_by->name }}
                            </li>
                            <li>
                                <strong>Motivo de la cancelación: </strong>
                                {{ $appointment->cancellation->justification }}
                            </li>
                        </ul>
                        @else
                        <ul>
                            <li>La cita fue cancelada antes de su confirmación.</li>
                        </ul>
                        @endif
                    </div>
                @endif

            </div>
            
            {{-- <div class="card-body">
              {{ $patients->links() }}
            </div> --}}
          </div>
@endsection