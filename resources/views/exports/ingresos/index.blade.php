<table>
    <thead>
        <tr>
            <th>Día</th>
            <th>Mes</th>
            <th>Año</th>
            <th>Nombres y apellidos del visitante</th>
            <th>Número de documento</th>
            <th>Tipo de visitante</th>
            <th>Persona que autoriza el ingreso</th>
            <th>Área de destino</th>
            <th>Hora de entrada</th>
            <th>Hora de salida</th>
            <th>Observaciones adicionales</th>
            <th>Persona que hizo el registro</th>
        </tr>
    </thead>
    <tbody>
        @forelse($ingresos as $ingreso)
        <tr>
            <td>{{$ingreso->dia_ingreso}}</td>
            <td>{{$ingreso->mes_ingreso}}</td>
            <td>{{$ingreso->anho_ingreso}}</td>
            <td>{{$ingreso->nombres_apellidos_visitante}}</td>
            <td>{{$ingreso->documento_visitante}}</td>
            <td>{{$ingreso->tipovisitante}}</td>
            <td>{{$ingreso->quien_autoriza}}</td>
            <td>{{$ingreso->servicio}}</td>
            <td>{{$ingreso->hora_ingreso}}</td>
            <td>{{$ingreso->hora_salida}}</td>
            <td>{{$ingreso->descripcion}}</td>
            <td>{{$ingreso->quien_registra}}</td>
        </tr>
        @empty
        <tr>
            <td>
                No hay información disponible
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
