<div class="mailbox-text">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="center">
                <span class="mailbox-title">
                    <i class="material-icons">build</i>
                    Información del comité: {{$comite->codigo}}

                </span>
            </div>
            <div class="divider mailbox-divider"></div>
            <div class="row">
                <div class="col s12 m2 l2">
                    <div class="row">
                        <ul class="collection">
                            <li class="collection-item">
                                <span class="title cyan-text text-darken-3">
                                    Fecha en la que se realizará el comité
                                </span>
                                <p>
                                    {{$comite->fechacomite->isoFormat('YYYY-MM-DD')}}
                                </p>
                            </li>
                            @include('comite.options')
                        </ul>
                    </div>
                </div>
                <div class="col s12 m10 l10">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="card-panel blue lighten-5">
                                <h5 class="center">Ideas que se agendaron para el comité</h5>
                                <table>
                                    <thead>
                                        <tr>
                                            <th style="width: 30%">Idea de proyecto</th>
                                            <th style="width: 40%">Dirección</th>
                                            <th style="width: 10%">Hora</th>
                                            @can('notificar_idea', [$comite, $comite->ideas->first()])
                                                <th style="width: 20%">Enviar citación</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($comite->ideas as $key => $value)
                                            <tr>
                                                <td>{{$value->codigo_idea}} - {{$value->nombre_proyecto}}</td>
                                                <td>{{$value->pivot->direccion}}</td>
                                                <td>{{$value->pivot->hora}}</td>
                                                @can('notificar_idea', [$comite, $value])
                                                    <td>
                                                        <a href="{{route('csibt.notificar.agendamiento', [$comite->id, $value->id ,'talentos'])}}">
                                                            <div class="card-panel blue-grey lighten-3 black-text center">
                                                                <i class="material-icons left">notifications</i>Enviar citación al talento.
                                                            </div>
                                                        </a>
                                                    </td>
                                                @endcan
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m10 l10 offset-m2 offset-l2">
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card-panel green lighten-5">
                            <h5 class="center">Expertos que se agendaron para el comité</h5>
                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="1" style="width: 60%">Experto</th>
                                        <th colspan="1" style="width: 20%">Desde</th>
                                        <th colspan="1" style="width: 20%">Hasta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($comite->gestores->isEmpty())
                                        <tr>
                                            <td>No se han encontrado resultados</td>
                                            <td>No se han encontrado resultados</td>
                                            <td>No se han encontrado resultados</td>
                                        </tr>
                                    @else
                                        @foreach ($comite->gestores as $key => $value2)
                                            <tr>
                                                <td colspan="1">{{$value2->user->documento}} - {{$value2->user->nombres}} {{$value2->user->apellidos}}</td>
                                                <td colspan="1">{{$value2->pivot->hora_inicio}}</td>
                                                <td colspan="1">{{$value2->pivot->hora_fin}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="divider mailbox-divider"></div>
</div>