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
          
        <tr>
            <td>
                {{isset($dinamizador) ? $dinamizador->user->documento : 'No registra'}}
            </td>
            <td>
                {{ isset($dinamizador) ? $dinamizador->user->nombres : ''}} {{isset($dinamizador) ? $dinamizador->user->apellidos : 'No registra'}}
            </td>
            <td>
                {{isset($dinamizador->user->fechanacimiento) ? $dinamizador->user->fechanacimiento->isoFormat('LL') : 'No registra'}}
            </td>
            <td>
                {{isset($dinamizador->user->email)? $dinamizador->user->email: 'No registra'}}
            </td>
            <td>
                {{!empty($dinamizador->user->telefono) ? $dinamizador->user->telefono : 'No registra'}}
            </td>
            <td>
                {{!empty($dinamizador->user->celular) ? $dinamizador->user->celular : 'No registra'}}
            </td>
          <td>{{ isset($dinamizador) ? $dinamizador->user->getRoleNames()->implode(', ') : 'No registra'}}</td>
        </tr>
    </tbody>
</table>