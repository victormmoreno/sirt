<div class="bg-primary no-m no-p">
    <div class="container-fluid no-m no-p">
        <div class="row no-m no-p">
            <div class="col s12 m12 l12">
                <div class="card card-transparent no-m">
                    <div class="card-content  white-text">
                        <div class="row">
                            <div class="col s12 m6 l6">
                                <h4 class=white-text>{{$idea->codigo_idea}} - {{$idea->datos_idea->nombre_proyecto->answer}}</h4>
                                <address>
                                    @if (isset($idea->user->nombres))
                                        {{$idea->user->nombres}} {{$idea->user->apellidos}}
                                    @else
                                        No hay información disponible
                                    @endif<br>
                                    @if (isset($idea->user->email))
                                        {{$idea->user->email}}
                                    @else
                                        No hay información disponible
                                    @endif
                                </address>
                            </div>
                            <div class="col s12 m12 l6 right-align">
                                <h4 class="white-text">Estado: {{$idea->estadoIdea->nombre}}</h4>
                                <h4 class="white-text">Tecnoparque {{$idea->nodo->entidad->nombre}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid no-m no-p">
    <div class="row no-m no-p">
        <div class="col s12 m12 l12 no-m no-p">
            <div class="card card-transparent no-m">
                <div class="card-content invoice-relative-content">
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12 no-m no-p">
                            <span class="card-title primary-text center no-m no-p">Descripción de la idea</span>
                            <div class="divider"></div>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l6">
                            <p>
                                <span class="primary-text">Código y nombre de la idea de proyecto</span><br>
                                <b>{{$idea->codigo_idea}} - {{$idea->datos_idea->nombre_proyecto->answer}}</b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l6">
                            <p>
                                <span class="primary-text">{{ $idea->datos_idea->producto_parecido->label }}</span><br>
                                <b>
                                    {{ $idea->datos_idea->producto_parecido->answer }}
                                    {{-- @if ($idea->producto_parecido == 1)
                                        Si.
                                        <br>
                                        {{$idea->si_producto_parecido}}
                                    @else
                                        No.
                                    @endif --}}
                                </b><br>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m12 l6">
                            <p>
                                <span class="primary-text">{{ $idea->datos_idea->reemplaza->label }}</span><br>
                                <b>
                                    {{ $idea->datos_idea->reemplaza->answer }}
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l6">
                            <p>
                                <span class="primary-text">{{$idea->datos_idea->descripcion->label}}</span><br>
                                <b>
                                    {{$idea->datos_idea->descripcion->answer}}
                                </b><br>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m12 l6">
                            <p>
                                <span class="primary-text">{{ $idea->datos_idea->producto_minimo_viable->label }}</span><br>
                                <b>
                                    {{ $idea->datos_idea->producto_minimo_viable->answer }}
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l6">
                            <p>
                                <span class="primary-text">{{$idea->datos_idea->ha_realizado_pruebas->label}}</span><br>
                                <b>
                                    {{$idea->datos_idea->ha_realizado_pruebas->answer}}
                                </b><br>
                            </p>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12 no-m no-p">
                            <span class="card-title primary-text center no-m no-p">Usuario que registra la idea</span>
                            <div class="divider"></div>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l4">
                            <p>
                                <span class="primary-text">Nombres y apellidos</span><br>
                                <b>
                                    @if (isset($idea->user->nombres))
                                        {{$idea->user->nombres}} {{$idea->user->apellidos}}
                                    @else
                                        No hay información disponible
                                    @endif
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l4">
                            <p>
                                <span class="primary-text">Correo de contacto</span><br>
                                <b>
                                    @if (isset($idea->user->email))
                                        {{$idea->user->email}}
                                    @else
                                        No hay información disponible
                                    @endif
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l4">
                            <p>
                                <span class="primary-text">Número de celular</span><br>
                                <b>
                                    @if (isset($idea->user->celular))
                                        {{$idea->user->celular}}
                                    @else
                                        No hay información disponible
                                    @endif
                                </b><br>
                            </p>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12 no-m no-p">
                            <span class="card-title primary-text center no-m no-p">Información de la aceptación del acuerdo de no confidencialidad de la idea</span>
                            <div class="divider"></div>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l6">
                            <p>
                                <span class="primary-text">¿El talento aceptó el acuerdo de no confidencialidad de la idea?</span><br>
                                <b>
                                    @if ($idea->datos_idea->fecha_acuerdo_no_confidencialidad->answer == null)
                                        No.
                                    @else
                                        Si.
                                    @endif
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l6">
                            <p>
                                <span class="primary-text">{{$idea->datos_idea->fecha_acuerdo_no_confidencialidad->label}}</span><br>
                                <b>
                                    {{$idea->datos_idea->fecha_acuerdo_no_confidencialidad->answer}}
                                </b><br>
                            </p>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12 no-m no-p">
                            <span class="card-title primary-text center no-m no-p">Empresa con la que se registra la idea de proyecto</span>
                            <div class="divider"></div>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l6">
                            <p>
                                <span class="primary-text">¿Esta idea de proyecto está registrada con una empresa?</span><br>
                                <b>
                                    @if ($idea->sede_id == null)
                                        No hay información disponible.
                                    @else
                                        Si.
                                    @endif
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l6">
                            @if ($idea->sede_id != null)
                            <p>
                                <span class="primary-text">Nombre de la empresa</span><br>
                                <b>
                                    {{$idea->sede->empresa->nit}} - {{$idea->sede->empresa->nombre}}
                                </b><br/>
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12 no-m no-p">
                            <span class="card-title primary-text center no-m no-p">{{$idea->datos_idea->pregunta1->label}}</span>
                            <div class="divider"></div>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12">
                            <p>
                                <b>
                                    {{$idea->datos_idea->pregunta1->answer}}
                                </b><br>
                            </p>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12 no-m no-p">
                            <span class="card-title primary-text center no-m no-p">{{$idea->datos_idea->modelo_negocio_definido->label}}</span>
                            <div class="divider"></div>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12">
                            <p>
                                <b>
                                    {{$idea->datos_idea->modelo_negocio_definido->answer}}
                                </b><br>
                            </p>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12 no-m no-p">
                            <span class="card-title primary-text center no-m no-p">¿Para quién creamos valor?</span>
                            <div class="divider"></div>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">{{$idea->datos_idea->quien_usa->label}}</span><br>
                                <b>
                                    {{$idea->datos_idea->quien_usa->answer}}
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">{{$idea->datos_idea->necesidades->label}}</span><br>
                                <b>
                                    {{$idea->datos_idea->necesidades->answer}}
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">{{$idea->datos_idea->problema->label}}</span><br>
                                <b>
                                    {{$idea->datos_idea->problema->answer}}
                                </b><br>
                            </p>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12 no-m no-p">
                            <span class="card-title primary-text center no-m no-p">Canales</span>
                            <div class="divider"></div>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">{{$idea->datos_idea->tipo_packing->label}}</span><br>
                                <b>
                                    {{$idea->datos_idea->tipo_packing->answer}}
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">{{$idea->datos_idea->estrategia_fijar_precio->label}}</span><br>
                                <b>
                                    {{$idea->datos_idea->estrategia_fijar_precio->answer}}
                                </b><br>
                            </p>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12 no-m no-p">
                            <span class="card-title primary-text center no-m no-p">Fuentes de ingresos</span>
                            <div class="divider"></div>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">{{$idea->datos_idea->recursos_necesarios->label}}</span><br>
                                <b>
                                    {{$idea->datos_idea->recursos_necesarios->answer}}
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">{{$idea->datos_idea->ha_generado_ventas->label}}</span><br>
                                <b>
                                    {{$idea->datos_idea->ha_generado_ventas->answer}}
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">{{$idea->datos_idea->apoyo_requerido->label}}</span><br>
                                <b>
                                    {{$idea->datos_idea->apoyo_requerido->answer}}
                                </b><br>
                            </p>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12 no-m no-p">
                            <span class="card-title primary-text center no-m no-p">Otros</span>
                            <div class="divider"></div>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">{{$idea->datos_idea->pregunta2->label}}</span><br>
                                <b>
                                    {{$idea->datos_idea->pregunta2->answer}}
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">{{$idea->datos_idea->requisitos_legales->label}}</span><br>
                                <b>
                                    {{$idea->datos_idea->requisitos_legales->answer}}
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">{{$idea->datos_idea->requiere_certificaciones->label}}</span><br>
                                <b>
                                    {{$idea->datos_idea->requiere_certificaciones->answer}}
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">{{$idea->datos_idea->pretende_forma_juridica->label}}</span><br>
                                <b>
                                    {{$idea->datos_idea->pretende_forma_juridica->answer}}
                                </b><br>
                            </p>
                        </div>
                        {{-- <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">{{$idea->datos_idea->link_video->label}}</span><br>
                                <b>
                                    {{$idea->datos_idea->link_video->answer}}
                                </b><br>
                            </p>
                        </div> --}}
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12 no-m no-p">
                            <span class="card-title primary-text center no-m no-p">{{$idea->datos_idea->version_beta->label}}</span>
                            <div class="divider"></div>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12">
                            <p>
                                <b>
                                    {{$idea->datos_idea->version_beta->answer}}
                                </b><br>
                            </p>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12 no-m no-p">
                            <span class="card-title primary-text center no-m no-p">Información de la Idea en la Red Tecnoparque</span>
                            <div class="divider"></div>
                        </div>
                    </div>
                    <div class="col s12 m12 l12">
                        <p>
                            <span class="primary-text">{{$idea->datos_idea->cantidad_prototipos->label}}</span><br>
                            <b>
                                {{$idea->datos_idea->cantidad_prototipos->answer}}
                            </b><br>
                        </p>
                    </div>
                    <div class="col s12 m12 l12">
                        <p>
                            <span class="primary-text">{{$idea->datos_idea->pregunta3->label}}</span><br>
                            <b>
                                {{$idea->datos_idea->pregunta3->answer}}
                            </b><br>
                        </p>
                    </div>
                    <div class="col s12 m12 l12">
                        <p>
                            <span class="primary-text">{{$idea->datos_idea->convocatoria->label}}</span><br>
                            <b>
                                {{$idea->datos_idea->convocatoria->answer}}
                            </b><br>
                        </p>
                    </div>
                    <div class="col s12 m12 l12">
                        <p>
                            <span class="primary-text">{{$idea->datos_idea->empresa->label}}</span><br>
                            <b>
                                {{$idea->datos_idea->empresa->answer}}
                            </b><br>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
