<table class="responsive-table striped highlight centered">
    <thead>
        <tr>
            <th>Tecnoparque</th>
            <th>Meta de {{__('Articulations')}}</th>
            <th class="green lighten-5">Total de {{__('Articulations')}} en Inicio</th>
            <th class="green lighten-5">Total de {{__('Articulations')}} en Ejecución</th>
            <th class="green lighten-5">Total de {{__('Articulations')}} en Cierre</th>
            <th class="green lighten-5">Total de {{__('Articulations')}} finalizadas del nodo</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($metasArticulaciones as $metaA)
            <tr>
                {{-- {{var_dump($metaA)}} --}}
                <td>{{$metaA->nodo}}</td>
                <td>{{$metaA->articulaciones}}</td>
                <td class="green lighten-5">{{$metaA->articulation_start}}</td>
                <td class="green lighten-5">{{$metaA->articulation_execution}}</td>
                <td class="green lighten-5">{{$metaA->articulation_closing}}</td>
                <td class="green lighten-5">{{$metaA->articulation_finish}} <b>({{$metaA->progreso_total_articulaciones}}%)</b></td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="center">No hay metas registradas para el año actual.</td>
            </tr>
        @endforelse
    </tbody>
    @if ($metasArticulaciones->count() != 0)
        <tfoot class="centered">
            <tr>
                <td><b>Total</b></td>
                <td><b>{{$metas->sum('articulaciones')}}</b></td>

                <td class="green lighten-5"><b>{{$metas->sum('articulation_start')}}</b></td>
                <td class="green lighten-5"><b>{{$metas->sum('articulation_execution')}}</b></td>
                <td class="green lighten-5"><b>{{$metas->sum('articulation_closing')}}</b></td>
                <td class="green lighten-5">
                    <b>
                        {{$metas->sum('articulation_finish')}} ({{round(100*($metas->sum('articulation_finish')/$metas->sum('articulaciones')), 2)}}%)
                    </b>
                </td>
            </tr>
        </tfoot>
    @endif
</table>
