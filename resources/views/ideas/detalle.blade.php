<div class="bg-primary no-m no-p">
    <div class="container-fluid no-m no-p">
        <div class="row no-m no-p">
            <div class="col s12 m12 l12">
                <div class="card card-transparent no-m">
                    <div class="card-content  white-text">
                        <div class="row">
                            <div class="col s12 m6 l6">
                                <h4 class=white-text>{{$idea->codigo_idea}} - {{$idea->nombre_proyecto}}</h4>
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
                                <h4 class="white-text">Nodo: {{$idea->nodo->entidad->nombre}}</h4>
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
                                <b>{{$idea->codigo_idea}} - {{$idea->nombre_proyecto}}</b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l6">
                            <p>
                                <span class="primary-text">¿Conoce una solución, producto, servicio o desarrollo parecido que actualmente esté disponible en el país o su región?</span><br>
                                <b>
                                    @if ($idea->producto_parecido == 1)
                                        Si.
                                        <br>
                                        {{$idea->si_producto_parecido}}
                                    @else
                                        No.
                                    @endif
                                </b><br>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m12 l6">
                            <p>
                                <span class="primary-text">¿La solución, producto o servicio reemplaza a algún otro existente?</span><br>
                                <b>
                                    @if ($idea->reemplaza == 1)
                                        Si.
                                        <br>
                                        {{$idea->si_reemplaza}}
                                    @else
                                        No.
                                    @endif
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l6">
                            <p>
                                <span class="primary-text">¿De qué se trata la solución y/o idea de negocio?</span><br>
                                <b>@if ($idea->descripcion == null)
                                        No hay información disponible
                                    @else
                                        {{$idea->descripcion}}
                                    @endif
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
                                    @if ($idea->acuerdo_no_confidencialidad == 0)
                                        No.
                                    @else
                                        Si.
                                    @endif
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l6">
                            <p>
                                <span class="primary-text">Fecha en la que aceptó el acuerdo</span><br>
                                <b>
                                    {{$idea->fecha_acuerdo_no_confidencialidad}}
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
                            <span class="card-title primary-text center no-m no-p">Estado actual la solución y/o idea de negocio</span>
                            <div class="divider"></div>
                        </div>
                    </div>
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12">
                            <p>
                                <b>
                                    {{{App\Models\Idea::preguntaUno($idea->pregunta1)}}}
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
                                <span class="primary-text">¿Qué problema de nuestros clientes (internos o externos) ayudamos a solucionar?</span><br>
                                <b>
                                    @if ($idea->problema == null)
                                        No hay información disponible
                                    @else
                                        {{$idea->problema}}
                                    @endif
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">¿Quién comprará la solución, producto o servicio?</span><br>
                                <b>
                                    @if ($idea->quien_compra == null)
                                        No hay información disponible
                                    @else
                                        {{$idea->quien_compra}}
                                    @endif
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">¿Qué necesidades de los clientes satisfacemos?</span><br>
                                <b>
                                    @if ($idea->necesidades == null)
                                        No hay información disponible
                                    @else
                                        {{$idea->necesidades}}
                                    @endif
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">¿Quién usará la solución, producto o servicio?</span><br>
                                <b>
                                    @if ($idea->quien_usa == null)
                                        No hay información disponible
                                    @else
                                        {{$idea->quien_usa}}
                                    @endif
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
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">¿Cuáles son los canales de distribución de tus productos/servicios? ¿Cómo se va a entregar/prestar al cliente?</span><br>
                                <b>
                                    @if ($idea->distribucion == null)
                                        No hay información disponible
                                    @else
                                        {{$idea->distribucion}}
                                    @endif
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">¿Vas a entregar directamente el producto y/o a través de intermediarios? ¿Por qué canales, on-line, punto de venta?</span><br>
                                <b>
                                    @if ($idea->quien_entrega == null)
                                        No hay información disponible
                                    @else
                                        {{$idea->quien_entrega}}
                                    @endif
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">¿El producto o servicio requiere algún tipo de packing?</span><br>
                                <b>
                                    @if ($idea->packing == 1)
                                        Si.
                                        <br>
                                        {{$idea->tipo_packing}}
                                    @else
                                        No.
                                    @endif
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
                                <span class="primary-text">¿Por qué medio se venderá el producto o servicio desarrollado?</span><br>
                                <b>
                                    @if ($idea->medio_venta == null)
                                        No hay información disponible
                                    @else
                                        {{$idea->medio_venta}}
                                    @endif
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">¿Por qué valor están dispuestos a pagar nuestros clientes?</span><br>
                                <b>
                                    @if ($idea->valor_clientes == null)
                                        No hay información disponible
                                    @else
                                        {{$idea->valor_clientes}}
                                    @endif
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
                                <span class="primary-text">¿Cómo está conformado su equipo de trabajo?</span><br>
                                <b>
                                    {{App\Models\Idea::preguntaDos($idea->pregunta2)}}
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">¿Hay requisitos legales a considerar en los países en donde se va a vender?</span><br>
                                <b>
                                    @if ($idea->requisitos_legales == 1)
                                        Si.
                                        <br>
                                        {{$idea->si_requisitos_legales}}
                                    @else
                                        No.
                                    @endif
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">¿Qué forma jurídica va a tener el negocio y por qué?</span><br>
                                <b>
                                    @if ($idea->forma_juridica == null)
                                        No hay información disponible
                                    @else
                                        {{$idea->forma_juridica}}
                                    @endif
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">¿La solución y/o idea de negocio requiere certificaciones o permisos especiales?</span><br>
                                <b>
                                    @if ($idea->requiere_certificaciones == 1)
                                        Si.
                                        <br>
                                        {{$idea->si_requiere_certificaciones}}
                                    @else
                                        No.
                                    @endif
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
                    <div class="row no-m no-p">
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">¿La solución, producto o servicio está aún en concepto o ya hay un prototipo o versión Beta?</span><br>
                                <b>
                                    @if ($idea->version_beta == null)
                                        No hay información disponible
                                    @else
                                        {{$idea->version_beta}}
                                    @endif
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">¿Cuáles y cuántos prototipos necesita desarrollar con la Red Tecnoparques?</span><br>
                                <b>
                                    @if ($idea->cantidad_prototipos == null)
                                        No hay información disponible
                                    @else
                                        {{$idea->cantidad_prototipos}}
                                    @endif
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">¿Se dispone de recursos para el desarrollo de los prototipos necesarios?</span><br>
                                <b>
                                    @if ($idea->recursos_necesarios == 1)
                                        Si.
                                        <br>
                                        {{$idea->si_recursos_necesarios}}
                                    @else
                                        No.
                                    @endif
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">¿En qué categoría se clasifica su idea?</span><br>
                                <b>
                                    {{App\Models\Idea::preguntaTres($idea->pregunta3)}}
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">Nodo donde se presenta la idea</span><br>
                                <b>
                                    {{$idea->nodo->entidad->nombre}}
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">¿Viene de una convocatoria?</span><br>
                                <b>
                                    @if ($idea->viene_convocatoria == 1)
                                        Si.
                                        <br>
                                        {{$idea->convocatoria}}
                                    @else
                                        No.
                                    @endif
                                </b><br>
                            </p>
                        </div>
                        <div class="col s12 m12 l12">
                            <p>
                                <span class="primary-text">¿La idea está avalada por una entidad?</span><br>
                                <b>
                                    @if ($idea->aval_empresa == 1)
                                        Si.
                                        <br>
                                        {{$idea->empresa}}
                                    @else
                                        No.
                                    @endif
                                </b><br>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
