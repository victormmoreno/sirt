<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<div class="row no-m-t no-m-b">
    <div class="col s12 m12 l12">
        <div class="mailbox-view">
            <div class="right">
                <small>
                    <b>Fecha de registro: </b>
                    {{optional($comite->created_at)->isoFormat('LL')}}
                </small>
            </div>
            <div class="divider mailbox-divider"></div>
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
                            <div class="col s12 m6 l6">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <span class="title cyan-text text-darken-3">
                                            Fecha en la que se realizó el comité
                                        </span>
                                        <p>
                                            {{$comite->fechacomite->isoFormat('YYYY-MM-DD')}}
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="col s12 m6 l6">
                                <ul class="collection">
                                    <li class="collection-item">
                                        <span class="title cyan-text text-darken-3">
                                            Observaciones del comité.
                                        </span>
                                        <p>
                                            {{$comite->observaciones}}
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <h5 class="center">Ideas que se presentaron en el comité</h5>
                                    <div class="row">
                                        @foreach ($comite->ideas as $key => $value)
                                        <div class="card light-blue lighten-4">
                                            <div class="card-content">
                                                <span class="card-title"><h5>#{{($key+1)}} | {{$value->codigo_idea}} - {{$value->nombre_proyecto}}</h5></span>
                                                <h5 class="center">Datos de la idea de proyecto</h5>
                                                <div class="divider"></div>
                                                <p>
                                                    <b class="black-text">
                                                        Nombres y apellidos de la persona que inscribió la idea de proyecto:
                                                    </b> {{$value->nombres_contacto}} {{$value->apellidos_contacto}}
                                                </p>
                                                <p>
                                                    <b class="black-text">
                                                        Teléfono de la persona que inscribió la idea de proyecto:
                                                    </b> {{$value->telefono_contacto}}
                                                </p>
                                                <p>
                                                    <b class="black-text">
                                                        Email de la persona que inscribió la idea de proyecto:
                                                    </b> {{$value->correo_contacto}}
                                                </p>
                                                <h5 class="center">Datos del agendamiento</h5>
                                                <div class="divider"></div>
                                                <p>
                                                   <b class="black-text">
                                                    Hora a la que se citó al comité:
                                                    </b> {{$value->pivot->hora}}
                                                </p>
                                                <p>
                                                   <b class="black-text">
                                                    Lugar/dirección donde se citó al comité:
                                                    </b> {{$value->pivot->direccion}}
                                                </p>
                                                <h5 class="center">Datos del comité</h5>
                                                <div class="divider"></div>
                                                <p>
                                                    <b class="black-text">
                                                        ¿Asisitó?:
                                                    </b> {{$value->pivot->asistencia == 0 ? 'No' : 'Si'}}
                                                </p>
                                                <p>
                                                    <b class="black-text">
                                                        ¿Fue admitida?:
                                                    </b> {{$value->pivot->admitido == 0 ? 'No' : 'Si'}}
                                                </p>
                                                <p>
                                                    <b class="black-text">
                                                        Observaciones:
                                                    </b> {{$value->pivot->observaciones}}
                                                </p>
                                                <h5 class="center">Datos de la asignación de proyectos</h5>
                                                <div class="divider"></div>
                                                <p>
                                                    <b class="black-text">
                                                        Gestor asignado a la idea de proyecto:
                                                    </b> 
                                                    @if ($value->pivot->admitido == 1)
                                                        @if(isset($value->gestor->user))
                                                        {{$value->gestor->user->nombres}} {{$value->gestor->user->apellidos}}
                                                        @else
                                                        Esta idea de proyecto no ha sido asignada a ningún gestor(a)
                                                        @endif
                                                    @else
                                                        Esta idea de proyecto no fue aprobada en el comité.
                                                    @endif
                                                </p>
                                            </div>
                                            @if (\Session::get('login_role') == App\User::IsDinamizador() || \Session::get('login_role') == App\User::IsInfocenter())
                                            <a href="javascript:void(0)" onclick="enviarNotificacionResultadosCSIBT({{$value->id}}, {{$comite->id}})">
                                                <div class="card-panel blue-grey lighten-3 black-text center">
                                                    <i class="material-icons left">notifications_active</i>
                                                    Enviar resultados del comité.
                                                    <i class="material-icons right">notifications_active</i>
                                                </div>
                                            </a>
                                            @endif
                                            @if ($value->pivot->admitido == 1)
                                                @if (\Session::get('login_role') == App\User::IsDinamizador())
                                                <a href="{{route('comite.cambiar.asignacion', [$value, $comite])}}">
                                                    <div class="card-panel yellow lighten-3 black-text center">
                                                        <i class="material-icons left">edit</i>
                                                        Cambiar asignación del gestor.
                                                        <i class="material-icons right">edit</i>
                                                    </div>
                                                </a>
                                                @endif
                                            @endif
                                          </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider mailbox-divider"></div>
            </div>
        </div>
    </div>
</div>