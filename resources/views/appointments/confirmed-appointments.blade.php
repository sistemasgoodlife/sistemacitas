<div class="table-responsive">
    <!-- Projects table -->
    <table class="table align-items-center table-flush">
      <thead class="thead-light">
        <tr>
          <th scope="col">Especialidad</th>
          <th scope="col">Médico</th>
          <th scope="col">Fecha</th>
          <th scope="col">Hora</th>
          <th scope="col">Tipo</th>
          <th scope="col">Estado</th>
          <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($confirmedAppointments as $cita)
          <tr>
              <th scope="row">
                {{ $cita->specialty->name }}
              </th>
              <td>
                {{ $cita->doctor->name }}
              </td>
              <td>
                {{ $cita->scheduled_date }}
              </td>
              <td>
                {{ $cita->Scheduled_Time_12 }}
              </td>
              <td>
                {{ $cita->type }}
              </td>
              <td>
                {{ $cita->status }}
              </td>
              <td>
                <a href="{{ url('/miscitas/'.$cita->id.'/cancel') }}" class="btn btn-sm btn-danger" title="Cancelar cita">Cancelar</a>
              </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>