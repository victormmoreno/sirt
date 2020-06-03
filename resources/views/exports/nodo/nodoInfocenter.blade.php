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
    </tr>
    </thead>
    <tbody>
      @foreach($infocenters as  $infocenter)
      
        <tr>
            <td>
                {{isset($infocenter) ? $infocenter->user->documento : 'No registra'}}
            </td>
            <td>
                {{ isset($infocenter) ? $infocenter->user->nombres : ''}} {{isset($infocenter) ? $infocenter->user->apellidos : 'No registra'}}
            </td>
            <td>
                {{isset($infocenter->user->fechanacimiento) ? $infocenter->user->fechanacimiento->isoFormat('LL') : 'No registra'}}
            </td>
            <td>
                {{isset($infocenter->user->email)? $infocenter->user->email: 'No registra'}}
            </td>
            <td>
                {{!empty($infocenter->user->telefono) ? $infocenter->user->telefono : 'No registra'}}
            </td>
            <td>
                {{!empty($infocenter->user->celular) ? $infocenter->user->celular : 'No registra'}}
            </td>
          <td>{{ isset($infocenter) ? $infocenter->user->getRoleNames()->implode(', ') : 'No registra'}}</td>
          
        </tr>
       
      @endforeach
    </tbody>
</table>