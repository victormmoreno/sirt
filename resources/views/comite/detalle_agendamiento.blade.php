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
                <div class="col s12 m12 l12">
                    <div class="row">
                        <ul class="collection">
                            <li class="collection-item">
                                <span class="title cyan-text text-darken-3">
                                    Fecha en la que se realiza el comité
                                </span>
                                <p>
                                    {{$comite->fechacomite->isoFormat('YYYY-MM-DD')}}
                                </p>
                            </li>
                        </ul>
                    </div>
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
                                            @can('notificar_comite', [$comite, $comite->ideas->first()])
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
                                                @can('notificar_comite', [$comite, $value])
                                                    <td>
                                                        <a href="{{route('csibt.notificar.agendamiento', [$comite->id, $value->id ,'talentos'])}}">
                                                            <div class="card-panel {{$value->pivot->notificado >= 1 ? 'green lighten-3' : 'blue-grey lighten-3'}} black-text center">
                                                                <i class="material-icons left">notifications</i>Enviar citación al talento.
                                                            </div>
                                                        </a>
                                                    </td>
                                                @endcan
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <ul class="collapsible">
                                                        <li>
                                                            <div class="collapsible-header"><i class="material-icons">supervised_user_circle</i>Datos del talento</div>
                                                            <div class="collapsible-body">
                                                                <p>
                                                                    <b class="black-text">
                                                                        Nombres y apellidos de la persona que inscribió la idea de proyecto:
                                                                    </b> 
                                                                    @if (isset($value->user->nombres))
                                                                    {{$value->user->nombres}} {{$value->user->apellidos}}
                                                                    @else
                                                                        No hay información disponible
                                                                    @endif
                                                                    <br>
                                                                    <b class="black-text">
                                                                        Celular de la persona que inscribió la idea de proyecto:
                                                                    </b> 
                                                                    @if (isset($value->user->celular))
                                                                        {{$value->user->celular}}
                                                                    @else
                                                                        No hay información disponible
                                                                    @endif
                                                                    <br>
                                                                    <b class="black-text">
                                                                        Email de la persona que inscribió la idea de proyecto:
                                                                    </b> 
                                                                    @if (isset($value->user->email))
                                                                        {{$value->user->email}}
                                                                    @else
                                                                        No hay información disponible
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </li>
                                                        @can('show_agendamiento', [$comite, $value])
                                                            <li>
                                                                <div class="collapsible-header {{ $value->pivot->admitido == 1 ? 'green lighten-3' : 'red lighten-3'}}"><i class="material-icons">{{ $value->pivot->admitido == 1 ? 'done' : 'close'}}</i>Resultado del comité</div>
                                                                <div class="collapsible-body">
                                                                    <p>
                                                                        <b class="black-text">
                                                                             ¿Asisitó?:
                                                                         </b> {{$value->pivot->asistencia == 0 ? 'No' : 'Si'}}
                                                                         <br>
                                                                         <b class="black-text">
                                                                             ¿Fue admitida?:
                                                                         </b> {{$value->pivot->admitido == 0 ? 'No' : 'Si'}}
                                                                         <br>
                                                                         <b class="black-text">
                                                                             Observaciones:
                                                                         </b> {{$value->pivot->observaciones == null ? 'No hay información disponible' : $value->pivot->observaciones}}
                                                                     </p>
                                                                </div>
                                                            </li>
                                                        @endcan
                                                        @can('show_asginacion', [$comite, $value])
                                                            <li>
                                                                <div class="collapsible-header"><i class="material-icons">assignment_ind</i>Asignación de idea</div>
                                                                <div class="collapsible-body">
                                                                    <p>
                                                                        <b class="black-text">
                                                                            Experto asignado a la idea de proyecto:
                                                                        </b> 
                                                                        @if ($value->pivot->admitido == 1)
                                                                            @if(isset($value->asesor))
                                                                            {{$value->asesor->nombres}} {{$value->asesor->apellidos}}
                                                                            @else
                                                                            Esta idea de proyecto no ha sido asignada a ningún experto(a)
                                                                            @endif
                                                                        @else
                                                                            Esta idea de proyecto no fue aprobada en el comité.
                                                                        @endif
                                                                    </p>
                                                                    <div class="row">
                                                                        @can('notificar_resultado', [$comite, $value])
                                                                            <div class="col s12 {{ $value->pivot->admitido == 1 ? 'm6 l6' : 'm12 l12'}}">
                                                                                <a href="javascript:void(0)" onclick="enviarNotificacionResultadosCSIBT({{$value->id}}, {{$comite->id}})">
                                                                                    <div class="card-panel blue-grey lighten-3 black-text center">
                                                                                        <i class="material-icons left">notifications_active</i>
                                                                                        Enviar resultados del comité.
                                                                                        <i class="material-icons right">notifications_active</i>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        @endcan
                                                                        @can('cambiar_asignacion', [$value, $comite])
                                                                        <div class="col s12 m6 l6">
                                                                            @if ($value->pivot->admitido == 1)
                                                                                <a href="{{route('comite.cambiar.asignacion', [$value, $comite])}}">
                                                                                    <div class="card-panel yellow lighten-3 black-text center">
                                                                                        <i class="material-icons left">edit</i>
                                                                                        Cambiar asignación del experto.
                                                                                        <i class="material-icons right">edit</i>
                                                                                    </div>
                                                                                </a>
                                                                            @endif
                                                                        </div>
                                                                        @endcan
                                                                    </div>
                                                                    @can('derivar_idea', [$comite, $value])
                                                                        <div class="row">
                                                                            <div class="col s12 m12 l12">
                                                                                <a href="javascript:void(0)" onclick="confirmacionDuplicidad( event, '{{route('idea.derivar', [$value->id, $comite->id, 1])}}' )">
                                                                                    <div class="card-panel green lighten-3 black-text center">
                                                                                        Duplicar idea de proyecto.
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    @endcan
                                                                </div>
                                                            </li>
                                                        @endcan
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m12 l12">
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
                                    @if ($comite->evaluadores->isEmpty())
                                        <tr>
                                            <td>No se han encontrado resultados</td>
                                            <td>No se han encontrado resultados</td>
                                            <td>No se han encontrado resultados</td>
                                        </tr>
                                    @else
                                        @foreach ($comite->evaluadores as $key => $value2)
                                            <tr>
                                                <td colspan="1">{{$value2->documento}} - {{$value2->nombres}} {{$value2->apellidos}}</td>
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
</div>