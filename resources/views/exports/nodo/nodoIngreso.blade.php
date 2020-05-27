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
      @foreach($ingresos as  $ingreso)
      
        <tr>
            <td>
                {{isset($ingreso) ? $ingreso->user->documento : 'No registra'}}
            </td>
            <td>
                {{ isset($ingreso) ? $ingreso->user->nombres : ''}} {{isset($ingreso) ? $ingreso->user->apellidos : 'No registra'}}
            </td>
            <td>
                {{isset($ingreso->user->fechanacimiento) ? $ingreso->user->fechanacimiento->isoFormat('LL') : 'No registra'}}
            </td>
            <td>
                {{isset($ingreso->user->email)? $ingreso->user->email: 'No registra'}}
            </td>
            <td>
                {{!empty($ingreso->user->telefono) ? $ingreso->user->telefono : 'No registra'}}
            </td>
            <td>
                {{!empty($ingreso->user->celular) ? $ingreso->user->celular : 'No registra'}}
            </td>
          <td>{{ isset($ingreso) ? $ingreso->user->getRoleNames()->implode(', ') : 'No registra'}}</td>
          
        </tr>
       
      @endforeach
    </tbody>
</table>