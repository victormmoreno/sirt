<table class="responsive-table striped highlight centered">
    <thead>
        <tr>
            <th>Tecnoparque</th>
            <th>Meta de PBTs finalizados</th>
            <th>Meta de TRL6</th>
            <th>Meta de TRL7 y TRL8</th>
            <th class="green lighten-5">Proyectos activos del nodo (Inicio, Planeación, Ejecución y Cierre)</th>
            <th class="green lighten-5">Total de proyectos TRL6 finalizados del nodo</th>
            <th class="green lighten-5">Total de proyectos TRL7 y TRL8 finalizados del nodo</th>
            <th class="green lighten-5">Total de proyectos finalizados del nodo</th>
        </tr>
    </thead>
    <tbody>
            @forelse ($metas as $meta)
                <tr>
                    <td>{{$meta->nodo}}</td>
                    <td>{{$meta->trl6 + $meta->trl7_trl8}}</td>
                    <td>{{$meta->trl6}}</td>
                    <td>{{$meta->trl7_trl8}}</td>
                    <td class="green lighten-5">{{$meta->activos}}</td>
                    <td class="green lighten-5">{{$meta->trl6_obtenido}}</td>
                    <td class="green lighten-5">{{$meta->trl7_8_obtenido}}</td>
                    <td class="green lighten-5">{{$meta->trl7_8_obtenido + $meta->trl6_obtenido}} <b>({{$meta->progreso_total_proyectos}}%)</b></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="center">No hay metas registradas para el año actual.</td>
                </tr>
            @endforelse
    </tbody>
    @if ($metas->count() != 0)
        <tfoot class="centered">
            <tr>
                <td class="center-align"><b>Total</b></td>
                <td  class="center-align"><b>{{$metas->sum('trl6') + $metas->sum('trl7_trl8')}}</b></td>
                <td  class="center-align"><b>{{$metas->sum('trl6')}}</b></td>
                <td  class="center-align"><b>{{$metas->sum('trl7_trl8')}}</b></td>
                <td class="green lighten-5 center-align"><b>{{$metas->sum('activos')}}</b></td>
                <td class="green lighten-5 center-align"><b>{{$metas->sum('trl6_obtenido')}}</b></td>
                <td class="green lighten-5 center-align"><b>{{$metas->sum('trl7_8_obtenido')}}</b></td>
                <td class="green lighten-5 center-align">
                    <b>
                        {{$metas->sum('trl7_8_obtenido') + $metas->sum('trl6_obtenido')}} ({{round(100*($metas->sum('trl7_8_obtenido') + $metas->sum('trl6_obtenido'))/($metas->sum('trl6') + $metas->sum('trl7_trl8')), 2)}}%)
                    </b>
                </td>
            </tr>
        </tfoot>
    @endif
</table>
