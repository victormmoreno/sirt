<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
@include('comite.historial_cambios')
<div class="divider"></div>
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
                                        <div class="card teal lighten-3">
                                            <div class="card-content">
                                                <span class="card-title"><h5>#{{($key+1)}} | {{$value->codigo_idea}} - {{$value->nombre_proyecto}}</h5></span>
                                                <h5 class="center">Datos de la idea de proyecto</h5>
                                                <div class="divider"></div>
                                                <p>
                                                    <b class="black-text">
                                                        Nombres y apellidos de la persona que inscribió la idea de proyecto:
                                                    </b> 
                                                    @if (isset($value->talento->user->nombres))
                                                    {{$value->talento->user->nombres}} {{$value->talento->user->apellidos}}
                                                    @else
                                                    {{$value->nombres_contacto}} {{$value->apellidos_contacto}}
                                                    @endif
                                                </p>
                                                <p>
                                                    <b class="black-text">
                                                        Celular de la persona que inscribió la idea de proyecto:
                                                    </b> 
                                                    @if (isset($value->talento->user->celular))
                                                        {{$value->talento->user->celular}}
                                                    @else
                                                        {{$value->telefono_contacto}}
                                                    @endif
                                                </p>
                                                <p>
                                                    <b class="black-text">
                                                        Email de la persona que inscribió la idea de proyecto:
                                                    </b> 
                                                    @if (isset($value->talento->user->email))
                                                        {{$value->talento->user->email}}
                                                    @else
                                                        {{$value->correo_contacto}}
                                                    @endif
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
                                            </div>
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