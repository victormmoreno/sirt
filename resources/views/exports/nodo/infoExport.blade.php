<br>
<br>
<br>
<br>
<br>
<br>
<table>
    <thead>
    <tr>
        <th>Documento de Identidad</th>
        <th>Nombres y Apellidos</th>
        <th>Fecha Nacimiento</th>
        <th>Correo Electrónico</th>
        <th>Teléfono</th>
        <th>Celular</th>
        <th>Cargo</th>
        <th>Linea Tecnonologica </th>
        <th>Honorario Mensual</th>

    </tr>
    </thead>
    <tbody>
      @foreach($gestores as $gestor)
        <tr>
            <td>
                {{isset($gestor) ? $gestor->user->documento : 'No registra'}}
            </td>
            <td>
                {{ isset($gestor) ? $gestor->user->nombres : ''}} {{isset($gestor) ? $gestor->user->apellidos : 'No registra'}}
            </td>
            <td>
                {{isset($gestor->user->fechanacimiento) ? $gestor->user->fechanacimiento->isoFormat('LL') : 'No registra'}}
            </td>
            <td>
                {{isset($gestor->user->email)? $gestor->user->email: 'No registra'}}
            </td>
            <td>
                {{!empty($gestor->user->telefono) ? $gestor->user->telefono : 'No registra'}}
            </td>
            <td>
                {{!empty($gestor->user->celular) ? $gestor->user->celular : 'No registra'}}
            </td>
          <td>{{ isset($gestor) ? $gestor->user->getRoleNames()->implode(', ') : 'No registra'}}</td>
          <td>{{ isset($gestor) ? $gestor->lineatecnologica->abreviatura : ''}} - {{ isset($gestor) ? $gestor->lineatecnologica->nombre : 'No registra'}}</td>
          <td>$ {{isset($gestor->honorarios) ? number_format($gestor->honorarios) : 0}}</td>
        </tr>
      @endforeach
    </tbody>
</table>