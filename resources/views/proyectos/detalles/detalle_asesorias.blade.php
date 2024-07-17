<div class="row">
    <div class="col s12 m4 l4">
        <ul class="collection">
            <li class="collection-item avatar">
                <i class="material-icons circle bg-primary">domain</i>
                <span class="title">Asesores del proyecto</span>
                <p>
                    Total de asesorias registradas: <b>{{ $proyecto->asesorias->count() }}</b>
                </p>
                <p>
                    @forelse ($proyecto->asesorias()->GetAsesoresProyecto($proyecto->id)->get() as $asesor)
                        {{$asesor->asesor}} con <b>{{$asesor->total_horas_asesoria}}</b> horas
                        <br>
                    @empty
                        Nadie ha asesorado este proyecto en el momento
                    @endforelse
                </p>
                <p>
                    Horas de asesoria totales: <b>{{ $costos_asesorias->getData()->horasAsesorias }}</b>.
                </p>
                @can('showConfInformation', $proyecto)
                    <p>
                        Total de costos de asesoria: <b>{{ asMoney($costos_asesorias->getData()->costosAsesorias) }}</b>.
                    </p>
                @endcan
            </li>
            <li class="collection-item avatar">
                <i class="material-icons circle bg-primary">account_balance_wallet</i>
                <span class="title">Equipos</span>
                <p>
                    Horas de uso de equipo totales: <b>{{$costos_asesorias->getData()->horasEquipos}}</b>.
                </p>
                @can('showConfInformation', $proyecto)
                    <p>
                        Total de costos de uso de equipos: <b>{{ asMoney($costos_asesorias->getData()->costosEquipos) }}</b>.
                    </p>
                @endcan
            </li>
            @can('showConfInformation', $proyecto)
                <li class="collection-item avatar">
                    <i class="material-icons circle bg-primary">local_library</i>
                    <span class="title">Materiales de formación</span>
                    <p>
                        Total de costos de materiales de formación: <b>{{asMoney($costos_asesorias->getData()->costosMateriales)}}</b>.
                    </p>
                </li>
                <li class="collection-item avatar">
                    <i class="material-icons circle bg-primary">attach_money</i>
                    <span class="title">Costo total del proyecto: <b>{{asMoney($costos_asesorias->getData()->costosTotales)}}<b/></span>
                </li>
            @endcan
        </ul>
    </div>
    <div class="col s12 m8 l8">
        <table class="highlight responsive-table">
            <thead>
                <tr>
                    <th>Código de asesoría</th>
                    <th>Fecha</th>
                    <th>Horas de asesoría</th>
                    <th>Horas de uso de equipos</th>
                    <th>Detalle</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($proyecto->asesorias as $asesoria)
                    <tr>
                        <td>{{ $asesoria->codigo }}</td>
                        <td>{{ $asesoria->fecha->format('Y-m-d') }}</td>
                        <td>{{ asNumber($asesoria->GetHorasAsesoria($asesoria->id)->first()->total_horas_asesoria) }}</td>
                        <td>{{ asNumber($asesoria->GetUsoEquipos($asesoria->id)->first()->uso_equipos) }}</td>
                        <td>
                            <a class="btn tooltipped bg-info m-b-xs" target="_blank" data-position="bottom" data-delay="50" data-tooltip="Ver detalle" href="{{route("asesorias.show", $asesoria->codigo)}}" >
                                <i class="material-icons">visibility</i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="center" colspan="5">No se encontraron asesorías registradas para este proyecto</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>