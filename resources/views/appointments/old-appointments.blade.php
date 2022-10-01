<div class="table-responsive">
    <!-- Projects table -->
    <table class="table align-items-center table-flush">
      <thead class="thead-light">
        <tr>
          <th scope="col">Especialidad</th>
          <th scope="col">Fecha</th>}
          <th scope="col">Estado</th>
          <th scope="col">Opciones</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($oldAppointments as $cita)
          <tr>
              <th scope="row">
                {{ $cita->specialty->name }}
              </th>
              <td>
                {{ $cita->scheduled_date }}
              </td>
              <td>
                {{ $cita->status }}
              </td>
              <td>

                <a href="{{ url('/miscitas/'.$cita->id) }}" class="btn btn-info btn-sm">
                  Ver
                </a>
                
              </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>