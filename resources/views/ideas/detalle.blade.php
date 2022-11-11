<div class="row">
    <div class="col s12 m12 l12">
        <div class="card-transparent">
            <div class="card-content">
                <div class="row no-m-t no-m-b">
                    <div class="col s12 m12 l12">
                        <div class="mailbox-view">
                            <div class="mailbox-text">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <div class="center">
                                            <span class="mailbox-title">
                                                Estado de la idea de proyecto - {{$idea->estadoIdea->nombre}}
                                            </span>
                                        </div>
                                        <div class="divider mailbox-divider"></div>
                                        <div class="row">
                                            <ul class="collection with-header">
                                                <li class="collection-header"><h5>Descripción de la idea</h5></li>
                                                <li class="collection-item">
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    Código y nombre de la idea de proyecto
                                                                </span>
                                                                <p>
                                                                    {{$idea->codigo_idea}} - {{$idea->nombre_proyecto}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿De qué se trata la solución y/o idea de negocio?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->descripcion == null)
                                                                        No hay información disponible
                                                                    @else
                                                                        {{$idea->descripcion}}
                                                                    @endif
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿Conoce una solución, producto, servicio o desarrollo parecido que actualmente esté disponible en el país o su región?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->producto_parecido == 1)
                                                                        Si.
                                                                        <br>
                                                                        {{$idea->si_producto_parecido}}
                                                                    @else
                                                                        No.
                                                                    @endif
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿La solución, producto o servicio reemplaza a algún otro existente?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->reemplaza == 1)
                                                                        Si.
                                                                        <br>
                                                                        {{$idea->si_reemplaza}}
                                                                    @else
                                                                        No.
                                                                    @endif
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </li>
                                            </ul>
                                            <ul class="collection with-header">
                                                <li class="collection-header"><h5 class="primary-text">Usuario que registra la idea</h5></li>
                                                <li class="collection-item">
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    Nombres y apellidos
                                                                </span>
                                                                <p>
                                                                    @if (isset($idea->talento->user->nombres))
                                                                    {{$idea->talento->user->nombres}} {{$idea->talento->user->apellidos}}
                                                                    @else
                                                                    {{$idea->nombres_contacto}} {{$idea->apellidos_contacto}}
                                                                    @endif
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    Correo de contacto
                                                                </span>
                                                                <p>
                                                                    @if (isset($idea->talento->user->email))
                                                                    {{$idea->talento->user->email}}
                                                                    @else
                                                                    {{$idea->correo_contacto}}
                                                                    @endif
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    Número de celular
                                                                </span>
                                                                <p>
                                                                    @if (isset($idea->talento->user->celular))
                                                                        {{$idea->talento->user->celular}}
                                                                    @else
                                                                        {{$idea->telefono_contacto}}
                                                                    @endif
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </li>
                                            </ul>
                                            <ul class="collection with-header">
                                                <li class="collection-header"><h5>Información de la aceptación del acuerdo de no confidencialidad de la idea</h5></li>
                                                <li class="collection-item">
                                                    <span class="title cyan-text text-darken-3">
                                                        ¿El talento aceptó el acuerdo de no confidencialidad de la idea?
                                                    </span>
                                                    <p>
                                                        @if ($idea->acuerdo_no_confidencialidad == 0)
                                                            No.
                                                        @else
                                                            Si.
                                                        @endif
                                                    </p>
                                                </li>
                                                @if ($idea->acuerdo_no_confidencialidad == 1)
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Fecha en la que aceptó el acuerdo
                                                        </span>
                                                        <p>
                                                            {{$idea->fecha_acuerdo_no_confidencialidad}}
                                                        </p>
                                                    </li>
                                                @endif
                                            </ul>
                                            <ul class="collection with-header">
                                                <li class="collection-header"><h5>Empresa con la que se registra la idea de proyecto</h5></li>
                                                <li class="collection-item">
                                                    <span class="title cyan-text text-darken-3">
                                                        ¿Esta idea de proyecto está registrada con una empresa?
                                                    </span>
                                                    <p>
                                                        @if ($idea->sede_id == null)
                                                            No hay información disponible.
                                                        @else
                                                            Si.
                                                        @endif
                                                    </p>
                                                </li>
                                                @if ($idea->sede_id != null)
                                                    <li class="collection-item">
                                                        <span class="title cyan-text text-darken-3">
                                                            Nombre de la empresa
                                                        </span>
                                                        <p>
                                                            {{$idea->sede->empresa->nit}} - {{$idea->sede->empresa->nombre}}
                                                        </p>
                                                    </li>
                                                @endif
                                            </ul>
                                            <ul class="collection with-header">
                                                <li class="collection-header"><h5>Estado actual la solución y/o idea de negocio</h5></li>
                                                <li class="collection-item">
                                                    {{{App\Models\Idea::preguntaUno($idea->pregunta1)}}}
                                                </li>
                                            </ul>
                                            <ul class="collection with-header">
                                                <li class="collection-header"><h5>¿Para quién creamos valor?</h5></li>
                                                <li class="collection-item">
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿Qué problema de nuestros clientes (internos o externos) ayudamos a solucionar?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->problema == null)
                                                                        No hay información disponible
                                                                    @else
                                                                        {{$idea->problema}}
                                                                    @endif
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿Qué necesidades de los clientes satisfacemos?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->necesidades == null)
                                                                        No hay información disponible
                                                                    @else
                                                                        {{$idea->necesidades}}
                                                                    @endif
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿Quién comprará la solución, producto o servicio?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->quien_compra == null)
                                                                        No hay información disponible
                                                                    @else
                                                                        {{$idea->quien_compra}}
                                                                    @endif
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿Quién usará la solución, producto o servicio?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->quien_usa == null)
                                                                        No hay información disponible
                                                                    @else
                                                                        {{$idea->quien_usa}}
                                                                    @endif
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                            <ul class="collection with-header">
                                                <li class="collection-header"><h5>Canales</h5></li>
                                                <li class="collection-item">
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿Cuáles son los canales de distribución de tus productos/servicios? ¿Cómo se va a entregar/prestar al cliente?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->distribucion == null)
                                                                        No hay información disponible
                                                                    @else
                                                                        {{$idea->distribucion}}
                                                                    @endif
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿Vas a entregar directamente el producto y/o a través de intermediarios? ¿Por qué canales, on-line, punto de venta?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->quien_entrega == null)
                                                                        No hay información disponible
                                                                    @else
                                                                        {{$idea->quien_entrega}}
                                                                    @endif
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿El producto o servicio requiere algún tipo de packing?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->packing == 1)
                                                                        Si.
                                                                        <br>
                                                                        {{$idea->tipo_packing}}
                                                                    @else
                                                                        No.
                                                                    @endif
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                            <ul class="collection with-header">
                                                <li class="collection-header"><h5>Fuentes de ingresos</h5></li>
                                                <li class="collection-item">
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿Por qué medio se venderá el producto o servicio desarrollado?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->medio_venta == null)
                                                                        No hay información disponible
                                                                    @else
                                                                        {{$idea->medio_venta}}
                                                                    @endif
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿Por qué valor están dispuestos a pagar nuestros clientes?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->valor_clientes == null)
                                                                        No hay información disponible
                                                                    @else
                                                                        {{$idea->valor_clientes}}
                                                                    @endif
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                            <ul class="collection with-header">
                                                <li class="collection-header"><h5>Otros</h5></li>
                                                <li class="collection-item">
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿Cómo está conformado su equipo de trabajo?
                                                                </span>
                                                                <p>
                                                                    {{App\Models\Idea::preguntaDos($idea->pregunta2)}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿Qué forma jurídica va a tener el negocio y por qué?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->forma_juridica == null)
                                                                        No hay información disponible
                                                                    @else
                                                                        {{$idea->forma_juridica}}
                                                                    @endif
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    Link de un video presentado la plataforma
                                                                </span>
                                                                <p>
                                                                    @if ($idea->rutamodel == null)
                                                                        No hay información disponible
                                                                    @else
                                                                        {{$idea->rutamodel->ruta}}
                                                                    @endif
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿Hay requisitos legales a considerar en los países en donde se va a vender?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->requisitos_legales == 1)
                                                                        Si.
                                                                        <br>
                                                                        {{$idea->si_requisitos_legales}}
                                                                    @else
                                                                        No.
                                                                    @endif
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿La solución y/o idea de negocio requiere certificaciones o permisos especiales?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->requiere_certificaciones == 1)
                                                                        Si.
                                                                        <br>
                                                                        {{$idea->si_requiere_certificaciones}}
                                                                    @else
                                                                        No.
                                                                    @endif
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                            <ul class="collection with-header">
                                                <li class="collection-header"><h5>Información de la Idea en la Red Tecnoparque</h5></li>
                                                <li class="collection-item">
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿La solución, producto o servicio está aún en concepto o ya hay un prototipo o versión Beta?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->version_beta == null)
                                                                        No hay información disponible
                                                                    @else
                                                                        {{$idea->version_beta}}
                                                                    @endif
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿Se dispone de recursos para el desarrollo de los prototipos necesarios?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->recursos_necesarios == 1)
                                                                        Si.
                                                                        <br>
                                                                        {{$idea->si_recursos_necesarios}}
                                                                    @else
                                                                        No.
                                                                    @endif
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿En qué categoría se clasifica su idea?
                                                                </span>
                                                                <p>
                                                                    {{App\Models\Idea::preguntaTres($idea->pregunta3)}}
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿Cuáles y cuántos prototipos necesita desarrollar con la Red Tecnoparques?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->cantidad_prototipos == null)
                                                                        No hay información disponible
                                                                    @else
                                                                        {{$idea->cantidad_prototipos}}
                                                                    @endif
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    Nodo donde se presenta la idea
                                                                </span>
                                                                <p>
                                                                    {{$idea->nodo->entidad->nombre}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿Viene de una convocatoria?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->viene_convocatoria == 1)
                                                                        Si.
                                                                        <br>
                                                                        {{$idea->convocatoria}}
                                                                    @else
                                                                        No.
                                                                    @endif
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    ¿La idea está avalada por una entidad?
                                                                </span>
                                                                <p>
                                                                    @if ($idea->aval_empresa == 1)
                                                                        Si.
                                                                        <br>
                                                                        {{$idea->empresa}}
                                                                    @else
                                                                        No.
                                                                    @endif
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                            {{-- <ul class="collection with-header">
                                                <li class="collection-header"><h5>Talleres de fortalecimiento a los que ha asistido</h5></li>
                                                <li class="collection-item">
                                                    <div class="row">
                                                        <div class="col s12 m6 l6" style="padding: 0">
                                                            <ul class="collection">
                                                                <li class="collection-item">
                                                                    <span class="title cyan-text text-darken-3">
                                                                        Código del taller de fortalecimiento
                                                                    </span>
                                                                    <p>
                                                                        Código
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col s12 m6 l6" style="padding: 0">
                                                            <ul class="collection">
                                                                <li class="collection-item">
                                                                    <span class="title cyan-text text-darken-3">
                                                                        Fecha que se realizó el taller
                                                                    </span>
                                                                    <p>
                                                                        Fecha
                                                                    </p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="divider mailbox-divider"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
