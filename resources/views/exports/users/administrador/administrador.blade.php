<br>
<br>
<br>
<br>
<br>
<br>
<table>
  <thead>
    <tr>
      <th>Tipo Documento</th>
      <th>Documento</th>
      <th>Lugar Expedición Documento</th>
      <th>Nombre Completo</th>
      <th>Fecha de Nacimiento</th>
      <th>Edad</th>
      <th>Correo Electrónico</th>
      <th>Telefono</th>
      <th>Celular</th>
      <th>Dirección</th>
      <th>Lugar de residencia</th>
      <th>Genero</th>
      <th>Grupo Sanguineo</th>
      <th>Eps</th>
      <th>Otra Eps</th>
      <th>Grado Escolaridad</th>
      <th>Institución</th>
      <th>Titulo Obtenido</th>
      <th>Fecha Terminacion</th>
      <th>Ocupaciones</th>
    </tr>
  </thead>
  <tbody>

    @foreach($users as $user)
    <tr>
      {{-- <td>{{ $edt->codigo_edt }}</td> --}}
      <td>{{$user->tipodocumento->nombre}}</td>
      <td>{{$user->documento}}</td>
      <td>{{$user->ciudadexpedicion->nombre}} ({{$user->ciudadexpedicion->departamento->nombre}})</td>
      <td>{{$user->nombres}} {{$user->apellidos}}</td>
      <td>{{$user->fechanacimiento->isoFormat('LL')}}</td>
      <td>{{$user->fechanacimiento->age}} años</td>
      <td>{{$user->email}}</td>
      <td>{{!empty($user->telefono) ? $user->telefono : 'No registra'}}</td>
      <td>{{!empty($user->celular) ? $user->celular : 'No registra'}}</td>
      <td>{{!empty($user->direccion) ? $user->direccion : 'No registra'}}</td>
      <td>{{$user->ciudad->nombre}} ({{$user->ciudad->departamento->nombre}})</td>
      <td>{{$user->genero == App\User::IsMasculino() ? 'Masculino' : 'Femenino'}}</td>
      <td>asfasdf</td>
      <td>asfasdf</td>
      <td>asfasdf</td>
      <td>asfasdf</td>
      <td>asfasdf</td>
      <td>asfasdf</td>
      <td>asfasdf</td>
    </tr>
    @endforeach
  </tbody>
</table>