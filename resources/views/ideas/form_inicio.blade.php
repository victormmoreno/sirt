{!! csrf_field() !!}
@php
$existe = isset($idea) ? true : false;
@endphp
<div class="row">
    <div class="col s12 m4 l4">
        <div class="card-panel grey lighten-1 black-text center">
            <i class="material-icons left">info_outline</i>
            Antes de empezar a registrar la idea de proyecto, es importante saber en que nodo se va a presentar.
            </div>
    </div>
    <input type="hidden" name="txtopcionRegistro" id="txtopcionRegistro" value="-1">
    <div class="input-field col s12 m8 l8">
        <i class="material-icons prefix">
            domain
        </i>
        <select id="txtnodo" name="txtnodo" style="width: 100%" tabindex="-1" readonly>
            <option value disabled>Seleccione Nodo</option>
                @foreach($nodos as $nodo)
                    @if($existe)
                        @if ($idea->nodo_id == $nodo->id)
                            @if($nodo->id == 20)
                                <option value="{{$nodo->id}}" selected>Hub Innovación Medellín</option>
                            @else
                                <option value="{{$nodo->id}}" selected>{{$nodo->nodos}}</option>
                            @endif
                        @else
                            @if($nodo->id == 20)
                                <option value="{{$nodo->id}}">Hub Innovación Medellín</option>
                            @else
                                <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                            @endif
                        @endif
                    @else
                        @if($nodo->id == 20)
                            <option value="{{$nodo->id}}">Hub Innovación Medellín</option>
                        @else
                            <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                        @endif
                    @endif
                @endforeach
        </select>
        <label class="truncate" for="txtnodo">Seleccione el nodo donde se presentará la idea <span class="red-text">*</span></label>
        <small id="txtnodo-error" class="error red-text"></small>
    </div>
</div>
<div class="row">
    <div class="card-panel grey lighten-1 black-text center">
        <i class="material-icons left">info_outline</i>
        A su vez, es importante para nosotros saber si usted está de acuerdo con el acuerdo de no confidencialidad de la idea.
    </div>
</div>
<div class="row center">
    <div class="form-check">
        @if ($existe)
            @if ($idea->acuerdo_no_confidencialidad == 1)
            <input class="form-check-input" type="checkbox" name="txtacuerdo_no_confidencialidad" id="txtacuerdo_no_confidencialidad" checked value="1">
            @else
            <input class="form-check-input" type="checkbox" name="txtacuerdo_no_confidencialidad" id="txtacuerdo_no_confidencialidad" value="1">
            @endif
        @else
        <input class="form-check-input" type="checkbox" name="txtacuerdo_no_confidencialidad" id="txtacuerdo_no_confidencialidad" value="1">
        @endif
        <label class="form-check-label black-text text-black" for="txtacuerdo_no_confidencialidad">
            Acepto el <a class="m-t-sm blue-text text-light-blue accent-4 center-align modal-trigger" href="#modalAcuerdoNoConfidencialidad">acuerdo de no confidencialidad de la idea.</a>
        </label>
    </div>
    <small id="txtacuerdo_no_confidencialidad-error" class="error red-text"></small>
</div>
<div class="divider"></div>
<div class="row">
    <div class="col s12 m12 l12">
        <h4 class="card-title center-align">Información de la empresa</h4>
    </div>
</div>
<div class="row">
    <div class="card-panel center green lighten-3">
        <span class="black-text text-black">¿Esta idea será desarrollada por una empresa?</span>
        <div class="switch m-b-md">
            <label class="black-text">
                No
                @if ($existe)
                    @if ($idea->sede_id != null)
                    <input type="checkbox" name="txtidea_empresa" id="txtidea_empresa" checked value="1" onchange="showInput_BuscarEmpresa()">
                    @else
                    <input type="checkbox" name="txtidea_empresa" id="txtidea_empresa" value="1" onchange="showInput_BuscarEmpresa()">
                    @endif
                @else
                <input type="checkbox" name="txtidea_empresa" id="txtidea_empresa" value="1" onchange="showInput_BuscarEmpresa()">
                @endif
                <span class="lever"></span>
                Si
            </label>
        </div>
    </div>
</div>
<div class="row" id="buscarEmpresa_content">
    <div class="input-field col s8 m8 l8">
        @if ($existe)
            @if ($idea->sede_id != null)
            <input type="text" id="txtnit" name="txtnit" value="{{ $idea->sede->empresa->nit }}">
            @else
            <input type="text" id="txtnit" name="txtnit" value="">
            @endif
        @else
        <input type="text" id="txtnit" name="txtnit" value="">
        @endif
        <label for="txtnit">Nit de la empresa (Sin puntos) <span class="red-text">*</span></label>
        <small id="txtnit-error" class="error red-text"></small>
    </div>
    <div class="col s4 m4 l4">
        <a href="javascript:void(0)" onclick="consultarEmpresaTecnoparque()">
            <div class="card-panel blue lighten-2 black-text center">
                Consultar empresa.
                <i class="material-icons right">search</i>
            </div>
            </a>
    </div>
</div>
<div class="card-panel amber lighten-4" id="registrarEmpresa_content">
    <h4 class="center">Registrar una nueva empresa</h4>
    <div class="divider"></div>
    @include('empresa.form', ['vista' => 'ideas'])
    <div class="divider"></div>
    @include('empresa.form_sedes', ['vista' => 'ideas'])
</div>
<div class="card-panel green lighten-5" id="consultarEmpresa_content">
    <div class="divider"></div>
    <h4 class="center">Empresa registrada</h4>
    @include('empresa.detalle_registrado')
    <div class="divider"></div>
    <h4 class="center">Sedes registradas de la empresa</h4>
    <ul class="collection" id="sedesEmpresaFormIdea">

    </ul>
    <div class="divider"></div>
    <h4 class="center">Sede que se asociará a la idea de proyecto</h4>
    @if ($existe)
        @if ($idea->sede_id != null)
        <input type="text" disabled name="txtnombre_sede_disabled" id="txtnombre_sede_disabled" value="{{$idea->sede->nombre_sede}} - {{$idea->sede->direccion}} {{$idea->sede->ciudad->nombre}} ({{$idea->sede->ciudad->departamento->nombre}})">
        <input type="hidden" name="txtsede_id" id="txtsede_id" value="{{$idea->sede_id}}">
        @else
        <input type="text" disabled name="txtnombre_sede_disabled" id="txtnombre_sede_disabled" value="Primero debes seleccionar una sede">
        <input type="hidden" name="txtsede_id" id="txtsede_id">
        @endif
    @else
    <input type="text" disabled name="txtnombre_sede_disabled" id="txtnombre_sede_disabled" value="Primero debes seleccionar una sede">
    <input type="hidden" name="txtsede_id" id="txtsede_id">
    @endif
    <label for="txtnombre_sede_disabled">Sede a la que se asociará la idea de proyecto <span class="red-text">*</span></label>
    <small id="txtsede_id-error" class="error red-text"></small>
</div>
<div class="divider"></div>
<div class="row">
    <div class="col s12 m12 l12">
        <h4 class="card-title center-align">Descripción de la idea</h4>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            library_books
        </i>
        @if ($existe)
        <input type="text" id="txtnombre_proyecto" name="txtnombre_proyecto" value="{{ $idea->nombre_proyecto }}">
        @else
        <input type="text" id="txtnombre_proyecto" name="txtnombre_proyecto" value="">
        @endif
        <label for="txtnombre_proyecto">Nombre de la idea de proyecto <span class="red-text">*</span></label>
        <small id="txtnombre_proyecto-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            create
        </i>
        @if ($existe)
        <textarea class="materialize-textarea" id="txtdescripcion" length="3400" name="txtdescripcion">{{ $idea->descripcion }}</textarea>
        @else
        <textarea class="materialize-textarea" id="txtdescripcion" length="3400" name="txtdescripcion"></textarea>
        @endif
        <label for="txtdescripcion">
            Describa de forma concisa y clara de que trata su idea de emprendimiento, ¿qué productos o servicios va a ofertar?
        </label>
        <small id="txtdescripcion-error" class="error red-text"></small>
    </div>
</div>
<div class="row">
    <div class="col s12 m6 l6">
        <div class="row">
            <span class="black-text text-black">¿Conoce una solución, producto, servicio o desarrollo parecido que actualmente esté disponible en el país o su región?</span>
            <div class="switch m-b-md">
                <label>
                    No
                    @if ($existe)
                        @if ($idea->producto_parecido == 1)
                        <input type="checkbox" name="txtproducto_parecido" id="txtproducto_parecido" checked value="1" onchange="showInput_ProductoParecido()">
                        @else
                        <input type="checkbox" name="txtproducto_parecido" id="txtproducto_parecido" value="1" onchange="showInput_ProductoParecido()">
                        @endif
                    @else
                    <input type="checkbox" name="txtproducto_parecido" id="txtproducto_parecido" value="1" onchange="showInput_ProductoParecido()">
                    @endif
                    <span class="lever"></span>
                    Si
                </label>
            </div>
        </div>
        <div class="row" id="productoParecido_content">
            <div class="input-field col s12 m12 l12">
                @if ($existe)
                <textarea class="materialize-textarea" id="txtsi_producto_parecido" length="2100" name="txtsi_producto_parecido">{{ $idea->si_producto_parecido }}</textarea>
                @else
                <textarea class="materialize-textarea" id="txtsi_producto_parecido" length="2100" name="txtsi_producto_parecido"></textarea>
                @endif
                <label for="txtsi_producto_parecido">Indique como su producto o servicio mejora el que está actualmente en el país o su región. <span class="red-text">*</span></label>
                <small id="txtsi_producto_parecido-error" class="error red-text"></small>
            </div>
        </div>
    </div>
    <div class="col s12 m6 l6">
        <div class="row">
            <span class="black-text text-black">¿La solución, producto o servicio reemplaza a algún otro existente?</span>
            <div class="switch m-b-md">
                <label>
                    No
                    @if ($existe)
                        @if ($idea->reemplaza == 1)
                        <input type="checkbox" name="txtreemplaza" id="txtreemplaza" checked value="1" onchange="showInput_Reemplaza()">
                        @else
                        <input type="checkbox" name="txtreemplaza" id="txtreemplaza" value="1" onchange="showInput_Reemplaza()">
                        @endif
                    @else
                    <input type="checkbox" name="txtreemplaza" id="txtreemplaza" value="1" onchange="showInput_Reemplaza()">
                    @endif
                    <span class="lever"></span>
                    Si
                </label>
            </div>
        </div>
        <div class="row" id="reemplaza_content">
            <div class="input-field col s12 m12 l12">
                @if ($existe)
                <textarea class="materialize-textarea" id="txtsi_reemplaza" length="2100" name="txtsi_reemplaza">{{ $idea->si_reemplaza }}</textarea>
                @else
                <textarea class="materialize-textarea" id="txtsi_reemplaza" length="2100" name="txtsi_reemplaza"></textarea>
                @endif
                <label for="txtsi_reemplaza">Indique cuál es esa solución, producto o servicio que reemplaza<span class="red-text">*</span></label>
                <small id="txtsi_reemplaza-error" class="error red-text"></small>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col s12 m6 l6">
        <span class="black-text text-black">¿Cuenta con producto mínimo viable?</span>
        <div class="switch m-b-md">
            <label class="tooltipped" data-position="bottom" data-tooltip="Entendiendo que, producto mínimo viable es aquel producto, servicio o experiencia que cumple funciones mínimas y es validado en un mercado real">
                No
                @if ($existe)
                    @if ($idea->producto_minimo_viable == 1)
                    <input type="checkbox" name="rad_producto_minimo_viable" id="rad_producto_minimo_viable" checked value="1">
                    @else
                    <input type="checkbox" name="rad_producto_minimo_viable" id="rad_producto_minimo_viable" value="1">
                    @endif
                @else
                <input type="checkbox" name="rad_producto_minimo_viable" id="rad_producto_minimo_viable" value="1">
                @endif
                <span class="lever"></span>
                Si
            </label>
        </div>
    </div>
    <div class="col s12 m6 l6">
        <span class="black-text text-black">¿Has realizado pruebas de tu producto o servicio con posibles clientes?</span>
        <div class="switch m-b-md">
            <label>
                No
                @if ($existe)
                    @if ($idea->ha_realizado_pruebas == 1)
                    <input type="checkbox" name="rad_ha_realizado_pruebas" id="rad_ha_realizado_pruebas" checked value="1">
                    @else
                    <input type="checkbox" name="rad_ha_realizado_pruebas" id="rad_ha_realizado_pruebas" value="1">
                    @endif
                @else
                <input type="checkbox" name="rad_ha_realizado_pruebas" id="rad_ha_realizado_pruebas" value="1">
                @endif
                <span class="lever"></span>
                Si
            </label>
        </div>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <div class="input-field col s12 m12 l12">
        <h5 class="center">Estado actual la solución y/o idea de negocio</h5>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m4 l4">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta1 == 1)
                    <input class="pregunta1" id="radio1" name="pregunta1" type="radio" value="1" checked/>
                    @else
                    <input class="pregunta1" id="radio1" name="pregunta1" type="radio" value="1"/>
                    @endif
                @else
                <input class="pregunta1" id="radio1" name="pregunta1" type="radio" value="1"/>
                @endif
                <label for="radio1" class="black-text">
                    1. Tengo el problema identificado, pero no tengo claro que producto debo desarrollar para resolverlo.
                </label>
            </p>
        </div>
    </div>
    <div class="input-field col s12 m4 l4">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta1 == 2)
                    <input class="pregunta1" id="radio2" name="pregunta1" type="radio" value="2" checked/>
                    @else
                    <input class="pregunta1" id="radio2" name="pregunta1" type="radio" value="2"/>
                    @endif
                @else
                <input class="pregunta1" id="radio2" name="pregunta1" type="radio" value="2"/>
                @endif
                <label for="radio2" class="black-text">
                    2. Tengo la idea del producto que quiero desarrollar pero no sé cómo hacerlo.
                </label>
            </p>
        </div>
    </div>
    <div class="input-field col s12 m4 l4">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta1 == 3)
                    <input class="pregunta1" id="radio3" name="pregunta1" type="radio" value="3" checked/>
                    @else
                    <input class="pregunta1" id="radio3" name="pregunta1" type="radio" value="3"/>
                    @endif
                @else
                <input class="pregunta1" id="radio3" name="pregunta1" type="radio" value="3"/>
                @endif
                <label for="radio3" class="black-text">
                    3. Tengo la idea del producto que quiero desarrollar, tengo los conocimientos para hacerlo, pero no se qué pasos seguir para formular el proyecto.
                </label>
            </p>
        </div>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m4 l4">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta1 == 4)
                    <input class="pregunta1" id="radio4" name="pregunta1" type="radio" value="4" checked/>
                    @else
                    <input class="pregunta1" id="radio4" name="pregunta1" type="radio" value="4"/>
                    @endif
                @else
                <input class="pregunta1" id="radio4" name="pregunta1" type="radio" value="4"/>
                @endif
                <label for="radio4" class="black-text">
                    4. Tengo formulado el proyecto para desarrollar mi producto: tengo claros los objetivos, el alcance, los recursos y las actividades que debo realizar para conseguirlo, entre otros.
                </label>
            </p>
        </div>
    </div>
    <div class="input-field col s12 m4 l4">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta1 == 5)
                    <input class="pregunta1" id="radio5" name="pregunta1" type="radio" value="5" checked/>
                    @else
                    <input class="pregunta1" id="radio5" name="pregunta1" type="radio" value="5"/>
                    @endif
                @else
                <input class="pregunta1" id="radio5" name="pregunta1" type="radio" value="5"/>
                @endif
                <label for="radio5" class="black-text">
                    5. Mi proyecto está formulado y ya comencé la ejecución, pero necesito gestionar algunos recursos para poder avanzar.
                </label>
            </p>
        </div>
    </div>
    <div class="input-field col s12 m4 l4">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta1 == 6)
                    <input class="pregunta1" id="radio6" name="pregunta1" type="radio" value="6" checked/>
                    @else
                    <input class="pregunta1" id="radio6" name="pregunta1" type="radio" value="6"/>
                    @endif
                @else
                <input class="pregunta1" id="radio6" name="pregunta1" type="radio" value="6"/>
                @endif
                <label for="radio6" class="black-text">
                    6. Ya tengo un prototipo avanzado de mi producto y requiero gestionar algunos recursos para concluir mi proyecto.
                </label>
            </p>
        </div>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m4 l4">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta1 == 1)
                    <input class="pregunta1" id="radio1" name="pregunta1" type="radio" value="1" checked/>
                    @else
                    <input class="pregunta1" id="radio1" name="pregunta1" type="radio" value="1"/>
                    @endif
                @else
                <input class="pregunta1" id="radio1" name="pregunta1" type="radio" value="1"/>
                @endif
                <label for="radio1" class="black-text">
                    7. Ya tengo un prototipo final, he realizado pruebas y ajustes, tengo planteada la idea de negocio y requiero gestionar algunos recursos para implementarla.
                </label>
            </p>
        </div>
    </div>
    <div class="input-field col s12 m4 l4">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta1 == 8)
                    <input class="pregunta1" id="radio8" name="pregunta1" type="radio" value="8" checked/>
                    @else
                    <input class="pregunta1" id="radio8" name="pregunta1" type="radio" value="8"/>
                    @endif
                @else
                <input class="pregunta1" id="radio8" name="pregunta1" type="radio" value="8"/>
                @endif
                <label for="radio8" class="black-text">
                    8. No voy a desarrollar un producto, voy a comercializar un producto de otro fabricante.
                </label>
            </p>
        </div>
    </div>
    <div class="input-field col s12 m4 l4">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta1 == 9)
                    <input class="pregunta1" id="radio9" name="pregunta1" type="radio" value="9" checked/>
                    @else
                    <input class="pregunta1" id="radio9" name="pregunta1" type="radio" value="9"/>
                    @endif
                @else
                <input class="pregunta1" id="radio9" name="pregunta1" type="radio" value="9"/>
                @endif
                <label for="radio9" class="black-text">
                    9. Quiero desarrollar una página web para promocionar mi negocio actual.
                </label>
            </p>
        </div>
    </div>
</div>
<div class="row center">
    <div class="col s12 m12 l12">
        <span class="black-text text-black">¿Tiene un modelo de negocio definido?</span>
        <blockquote>
            Entendiendo que el modelo de negocio es una estructura lógica conformado por:  i) problema; ii) solución; iii) métricas claves; iv) propuesta de valor única (factor diferenciador o innovador); v) canales; vi) segmento de clientes; vii) estructura de costes; viii) flujo de ingresos; y, ix) ventaja especial; en la cual se logra identificar aspectos claves de la idea.
        </blockquote>
        <div class="switch m-b-md">
            <label>
                No
                @if ($existe)
                    @if ($idea->modelo_negocio_definido == 1)
                    <input type="checkbox" name="rad_modelo_negocio_definido" id="rad_modelo_negocio_definido" checked value="1">
                    @else
                    <input type="checkbox" name="rad_modelo_negocio_definido" id="rad_modelo_negocio_definido" value="1">
                    @endif
                @else
                <input type="checkbox" name="rad_modelo_negocio_definido" id="rad_modelo_negocio_definido" value="1">
                @endif
                <span class="lever"></span>
                Si
            </label>
        </div>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <div class="input-field col s12 m12 l12">
        <h5 class="center">¿Para quién creamos valor?</h5>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            pan_tool
        </i>
        @if ($existe)
        <textarea class="materialize-textarea" id="txtquien_usa" length="1400" name="txtquien_usa">{{ $idea->quien_usa }}</textarea>
        @else
        <textarea class="materialize-textarea" id="txtquien_usa" length="1400" name="txtquien_usa"></textarea>
        @endif
        <label for="txtquien_usa">
            ¿Quién usará la solución, producto o servicio?
        </label>
        <small id="txtquien_usa-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            sentiment_satisfied
        </i>
        @if ($existe)
        <textarea class="materialize-textarea" id="txtnecesidades" length="3400" name="txtnecesidades">{{ $idea->necesidades }}</textarea>
        @else
        <textarea class="materialize-textarea" id="txtnecesidades" length="3400" name="txtnecesidades"></textarea>
        @endif
        <label for="txtnecesidades">
            ¿Qué necesidades de los clientes satisfacemos?
        </label>
        <small id="txtnecesidades-error" class="error red-text"></small>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m12 l12">
        <i class="material-icons prefix">
            settings
        </i>
        @if ($existe)
        <textarea class="materialize-textarea" id="txtproblema" length="3400" name="txtproblema">{{ $idea->problema }}</textarea>
        @else
        <textarea class="materialize-textarea" id="txtproblema" length="3400" name="txtproblema"></textarea>
        @endif
        <label for="txtproblema">
            ¿Qué problema de nuestros clientes (internos o externos) ayudamos a solucionar?
        </label>
        <small id="txtproblema-error" class="error red-text"></small>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <div class="input-field col s12 m12 l12">
        <h5 class="center">Canales</h5>
    </div>
</div>
<div class="row">
    {{-- <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            shopping_cart
        </i>
        @if ($existe)
        <textarea class="materialize-textarea" id="txtdistribucion" length="1400" name="txtdistribucion">{{ $idea->distribucion }}</textarea>
        @else
        <textarea class="materialize-textarea" id="txtdistribucion" length="1400" name="txtdistribucion"></textarea>
        @endif
        <label for="txtdistribucion">
            ¿Cuáles son los canales de distribución de tus productos/servicios? ¿Cómo se va a entregar/prestar al cliente?
        </label>
        <small id="txtdistribucion-error" class="error red-text"></small>
    </div> --}}
    {{-- <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            web
        </i>
        @if ($existe)
        <textarea class="materialize-textarea" id="txtquien_entrega" length="1400" name="txtquien_entrega">{{ $idea->quien_entrega }}</textarea>
        @else
        <textarea class="materialize-textarea" id="txtquien_entrega" length="1400" name="txtquien_entrega"></textarea>
        @endif
        <label for="txtquien_entrega">
            ¿Vas a entregar directamente el producto y/o a través de intermediarios? ¿Por qué canales, on-line, punto de venta?
        </label>
        <small id="txtquien_entrega-error" class="error red-text"></small>
    </div> --}}
</div>
<div class="row">
    <div class="col s12 m6 l6">
        <span class="black-text text-black">¿El producto o servicio requiere algún tipo de empaque, embalaje o envase?</span>
        <div class="switch m-b-md">
            <label>
                No
                @if ($existe)
                    @if ($idea->packing == 1)
                    <input type="checkbox" name="txtpacking" id="txtpacking" checked value="1">
                    @else
                    <input type="checkbox" name="txtpacking" id="txtpacking" value="1">
                    @endif
                @else
                <input type="checkbox" name="txtpacking" id="txtpacking" value="1">
                @endif
                <span class="lever"></span>
                Si
            </label>
        </div>

        {{-- <div class="row" id="packing_content">
            <div class="input-field col s12 m12 l12">
                @if ($existe)
                <textarea class="materialize-textarea" id="txttipo_packing" length="1400" name="txttipo_packing">{{ $idea->tipo_packing }}</textarea>
                @else
                <textarea class="materialize-textarea" id="txttipo_packing" length="1400" name="txttipo_packing"></textarea>
                @endif
                <label for="txttipo_packing">Indique cuál es el tipo de packing que se requiere <span class="red-text">*</span></label>
                <small id="txttipo_packing-error" class="error red-text"></small>
            </div>
        </div> --}}
    </div>
    <div class="col s12 m6 l6">
        <span class="black-text text-black">¿Cuenta con una estrategia para fijar el precio de su producto o servicio?</span>
        <div class="switch m-b-md">
            <label>
                No
                @if ($existe)
                    @if ($idea->estrategia_fijar_precio == 1)
                    <input type="checkbox" name="rad_estrategia_fijar_precio" id="rad_estrategia_fijar_precio" checked value="1">
                    @else
                    <input type="checkbox" name="rad_estrategia_fijar_precio" id="rad_estrategia_fijar_precio" value="1">
                    @endif
                @else
                <input type="checkbox" name="rad_estrategia_fijar_precio" id="rad_estrategia_fijar_precio" value="1">
                @endif
                <span class="lever"></span>
                Si
            </label>
        </div>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <div class="input-field col s12 m12 l12">
        <h5 class="center">Fuentes de ingresos</h5>
    </div>
</div>
<div class="row">
    <div class="col s12 m6 l6">
        <span class="black-text text-black">
            ¿Cuenta con los recursos para la puesta en marcha del producto o servicio?
        </span>
        <div class="switch m-b-md">
            <label>
                No
                @if ($existe)
                    @if ($idea->recursos_necesarios == 1)
                    <input type="checkbox" name="txtrecursos_necesarios" id="txtrecursos_necesarios" checked value="1">
                    @else
                    <input type="checkbox" name="txtrecursos_necesarios" id="txtrecursos_necesarios" value="1">
                    @endif
                @else
                <input type="checkbox" name="txtrecursos_necesarios" id="txtrecursos_necesarios" value="1">
                @endif
                <span class="lever"></span>
                Si
            </label>
        </div>
    </div>
    <div class="col s12 m6 l6">
        <span class="black-text text-black">
            ¿Tu producto o servicio ha generado ventas?
        </span>
        <div class="switch m-b-md">
            <label>
                No
                @if ($existe)
                    @if ($idea->ha_generado_ventas == 1)
                    <input type="checkbox" name="rad_ha_generado_ventas" id="rad_ha_generado_ventas" checked value="1">
                    @else
                    <input type="checkbox" name="rad_ha_generado_ventas" id="rad_ha_generado_ventas" value="1">
                    @endif
                @else
                <input type="checkbox" name="rad_ha_generado_ventas" id="rad_ha_generado_ventas" value="1">
                @endif
                <span class="lever"></span>
                Si
            </label>
        </div>
    </div>
</div>
<div class="row">
    <h5 class="center">¿Ha identificado algún tipo de recurso y/o apoyo requerido para la escalabilidad de la idea?</h5>
</div>
<div class="row">
    <div class="input-field col s12 m4 l4">
        {{-- <div class="section"> --}}
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->apoyo_requerido == 1)
                    <input class="apoyo_requerido" id="rad1_apoyo_requerido" name="apoyo_requerido" type="radio" value="1" checked/>
                    @else
                    <input class="apoyo_requerido" id="rad1_apoyo_requerido" name="apoyo_requerido" type="radio" value="1"/>
                    @endif
                @else
                <input class="apoyo_requerido" id="rad1_apoyo_requerido" name="apoyo_requerido" type="radio" value="1"/>
                @endif
                <label align="justify" for="rad1_apoyo_requerido" class="black-text">
                    1. Requiero apoyo en marketing o espacios comerciales
                </label>
            </p>
        {{-- </div> --}}
    </div>
    <div class="input-field col s12 m4 l4">
        {{-- <div class="section"> --}}
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->apoyo_requerido == 2)
                    <input class="apoyo_requerido" id="rad2_apoyo_requerido" name="apoyo_requerido" type="radio" value="2" checked/>
                    @else
                    <input class="apoyo_requerido" id="rad2_apoyo_requerido" name="apoyo_requerido" type="radio" value="2"/>
                    @endif
                @else
                <input class="apoyo_requerido" id="rad2_apoyo_requerido" name="apoyo_requerido" type="radio" value="2"/>
                @endif
                <label align="justify" for="rad2_apoyo_requerido" class="black-text">
                    2. Requiero inversionistas
                </label>
            </p>
        {{-- </div> --}}
    </div>
    <div class="input-field col s12 m4 l4">
        {{-- <div class="section"> --}}
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->apoyo_requerido == 3)
                    <input class="apoyo_requerido" id="rad3_apoyo_requerido" name="apoyo_requerido" type="radio" value="3" checked/>
                    @else
                    <input class="apoyo_requerido" id="rad3_apoyo_requerido" name="apoyo_requerido" type="radio" value="3"/>
                    @endif
                @else
                <input class="apoyo_requerido" id="rad3_apoyo_requerido" name="apoyo_requerido" type="radio" value="3"/>
                @endif
                <label align="justify" for="rad3_apoyo_requerido" class="black-text">
                    3. Requiero inversión de capital semilla de Fondo Emprender
                </label>
            </p>
        {{-- </div> --}}
    </div>
    <div class="input-field col s12 m4 l4 ">
        {{-- <div class="section "> --}}
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->apoyo_requerido == 4)
                    <input class="apoyo_requerido" id="rad4_apoyo_requerido" name="apoyo_requerido" type="radio" value="4" checked/>
                    @else
                    <input class="apoyo_requerido" id="rad4_apoyo_requerido" name="apoyo_requerido" type="radio" value="4"/>
                    @endif
                @else
                <input class="apoyo_requerido" id="rad4_apoyo_requerido" name="apoyo_requerido" type="radio" value="4"/>
                @endif
                <label align="justify" for="rad4_apoyo_requerido" class="black-text">
                    4. Requiero relacionamiento con Cámara de Comercio, Aceleradoras, Incubadores, entre otros aliados estratégicos
                </label>
            </p>
        {{-- </div> --}}
    </div>
    <div class="input-field col s12 m4 l4 ">
        {{-- <div class="section "> --}}
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->apoyo_requerido == 5)
                    <input class="apoyo_requerido" id="rad5_apoyo_requerido" name="apoyo_requerido" type="radio" value="4" checked/>
                    @else
                    <input class="apoyo_requerido" id="rad5_apoyo_requerido" name="apoyo_requerido" type="radio" value="4"/>
                    @endif
                @else
                <input class="apoyo_requerido" id="rad5_apoyo_requerido" name="apoyo_requerido" type="radio" value="4"/>
                @endif
                <label align="justify" for="rad5_apoyo_requerido" class="black-text">
                    5. No requiero ningún tipo de recurso para escalar mi idea. 
                </label>
            </p>
        {{-- </div> --}}
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <div class="input-field col s12 m12 l12">
        <h5 class="center">Otros</h5>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m12 l12">
        <h5 class="center">¿Cómo está conformado su equipo de trabajo?</h5>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta2 == 1)
                    <input class="pregunta2" id="rad1" name="pregunta2" type="radio" value="1" checked/>
                    @else
                    <input class="pregunta2" id="rad1" name="pregunta2" type="radio" value="1"/>
                    @endif
                @else
                <input class="pregunta2" id="rad1" name="pregunta2" type="radio" value="1"/>
                @endif
                <label align="justify" for="rad1" class="black-text">
                    1. No tengo equipo de trabajo, yo solo me encargaré de desarrollar el producto.
                </label>
            </p>
        </div>
    </div>
    <div class="input-field col s12 m6 l6">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta2 == 2)
                    <input class="pregunta2" id="rad2" name="pregunta2" type="radio" value="2" checked/>
                    @else
                    <input class="pregunta2" id="rad2" name="pregunta2" type="radio" value="2"/>
                    @endif
                @else
                <input class="pregunta2" id="rad2" name="pregunta2" type="radio" value="2"/>
                @endif
                <label align="justify" for="rad2" class="black-text">
                    2. Tengo un equipo de trabajo que cuenta con los conocimientos técnicos mínimos para el desarrollo del producto, pero no contamos con los conocimientos de mercadeo para la implementación de la idea de negocio.
                </label>
            </p>
        </div>
    </div>
    <div class="input-field col s12 m6 l6 section">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta2 == 3)
                    <input class="pregunta2" id="rad3" name="pregunta2" type="radio" value="3" checked/>
                    @else
                    <input class="pregunta2" id="rad3" name="pregunta2" type="radio" value="3"/>
                    @endif
                @else
                <input class="pregunta2" id="rad3" name="pregunta2" type="radio" value="3"/>
                @endif
                <label align="justify" for="rad3" class="black-text">
                    3. Tengo un equipo de trabajo que cuenta con los conocimientos de mercadeo mínimos para la implementación de la idea de negocio, pero no contamos con los conocimientos técnicos para desarrollar el producto.
                </label>
            </p>
        </div>
    </div>
    <div class="input-field col s12 m6 l6 ">
        <div class="section ">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta2 == 4)
                    <input class="pregunta2" id="rad4" name="pregunta2" type="radio" value="4" checked/>
                    @else
                    <input class="pregunta2" id="rad4" name="pregunta2" type="radio" value="4"/>
                    @endif
                @else
                <input class="pregunta2" id="rad4" name="pregunta2" type="radio" value="4"/>
                @endif
                <label align="justify" for="rad4" class="black-text">
                    4. Tengo un equipo de trabajo multidisciplinar, que cuenta con los conocimientos técnicos, conocimientos de gestión y conocimientos de mercadeo necesarios para el desarrollo del producto y la implementación de la idea de negocio.
                </label>
            </p>
        </div>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <div class="col s12 m6 l6">
        <div class="row">
            <span class="black-text text-black">¿Hay requisitos legales a considerar en los países en donde se va a vender?</span>
            <div class="switch m-b-md">
                <label>
                    No
                    @if ($existe)
                        @if ($idea->requisitos_legales == 1)
                        <input type="checkbox" name="txtrequisitos_legales" id="txtrequisitos_legales" checked value="1" onchange="showInput_RequisitosLegales()">
                        @else
                        <input type="checkbox" name="txtrequisitos_legales" id="txtrequisitos_legales" value="1" onchange="showInput_RequisitosLegales()">
                        @endif
                    @else
                    <input type="checkbox" name="txtrequisitos_legales" id="txtrequisitos_legales" value="1" onchange="showInput_RequisitosLegales()">
                    @endif
                    <span class="lever"></span>
                    Si
                </label>
            </div>
        </div>
        <div class="row" id="requisitosLegales_content">
            <div class="input-field col s12 m12 l12">
                @if ($existe)
                <textarea class="materialize-textarea" id="txtsi_requisitos_legales" length="2100" name="txtsi_requisitos_legales">{{ $idea->si_requisitos_legales }}</textarea>
                @else
                <textarea class="materialize-textarea" id="txtsi_requisitos_legales" length="2100" name="txtsi_requisitos_legales"></textarea>
                @endif
                <label for="txtsi_requisitos_legales">Indique los requisitos legales a considerar<span class="red-text">*</span></label>
                <small id="txtsi_requisitos_legales-error" class="error red-text"></small>
            </div>
        </div>
    </div>
    <div class="col s12 m6 l6">
        <div class="row">
            <span class="black-text text-black">
                ¿La solución y/o idea de negocio requiere certificaciones o permisos especiales?
                <br>
                Ejemplos: Invima, junta médica, certificaciones ISO, antinarcóticos, I+D+i, EFQM, UNE, entre otras certificaciones.
            </span>
            <div class="switch m-b-md">
                <label>
                    No
                    @if ($existe)
                        @if ($idea->requiere_certificaciones == 1)
                        <input type="checkbox" name="txtrequiere_certificaciones" id="txtrequiere_certificaciones" checked value="1" onchange="showInput_Certificaciones()">
                        @else
                        <input type="checkbox" name="txtrequiere_certificaciones" id="txtrequiere_certificaciones" value="1" onchange="showInput_Certificaciones()">
                        @endif
                    @else
                    <input type="checkbox" name="txtrequiere_certificaciones" id="txtrequiere_certificaciones" value="1" onchange="showInput_Certificaciones()">
                    @endif
                    <span class="lever"></span>
                    Si
                </label>
            </div>
        </div>
        <div class="row" id="certificaciones_content">
            <div class="input-field col s12 m12 l12">
                @if ($existe)
                <textarea class="materialize-textarea" id="txtsi_requiere_certificaciones" length="2100" name="txtsi_requiere_certificaciones">{{ $idea->si_requiere_certificaciones }}</textarea>
                @else
                <textarea class="materialize-textarea" id="txtsi_requiere_certificaciones" length="2100" name="txtsi_requiere_certificaciones"></textarea>
                @endif
                <label for="txtsi_requiere_certificaciones">Indique las certificaciones o permisos especiales<span class="red-text">*</span></label>
                <small id="txtsi_requiere_certificaciones-error" class="error red-text"></small>
            </div>
        </div>
    </div>
</div>
<div class="divider"></div>
<div class="col s12 m6 l6">
    <div class="row">
        <span class="black-text text-black">¿Es de su interés constituirse como persona natural o persona jurídica?</span>
        <div class="switch m-b-md">
            <label>
                No
                @if ($existe)
                    @if ($idea->forma_juridica == 1)
                    <input type="checkbox" name="txtforma_juridica" id="txtforma_juridica" checked value="1">
                    @else
                    <input type="checkbox" name="txtforma_juridica" id="txtforma_juridica" value="1">
                    @endif
                @else
                <input type="checkbox" name="txtforma_juridica" id="txtforma_juridica" value="1">
                @endif
                <span class="lever"></span>
                Si
            </label>
        </div>
    </div>
</div>
<div class="row">
    <span class="black-text text-black">
        Si tienes un vídeo donde expliques por qué tu idea es innovadora, quien es tu equipo de trabajo y por que requiere el apoyo de la Red Tecnoparque SENA, puedes adjuntar el link de ese video.
    </span>
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            ondemand_video
        </i>
        @if ($existe)
            @if ($idea->rutamodel == null)
                <input id="txtlinkvideo" name="txtlinkvideo" type="text" value="">
            @else
                <input id="txtlinkvideo" name="txtlinkvideo" type="text" value="{{$idea->rutamodel->ruta}}">
            @endif
        @else
        <input id="txtlinkvideo" name="txtlinkvideo" type="text">
        @endif
        <label for="txtlinkvideo">
            Ingresa el link del video
        </label>
        <small>La dirección de debe ser algo similar: <b>https://www.youtube.com/watch?v=J9LSfkVF2K4</b></small><br>
        <small id="txtlinkvideo-error" class="error red-text"></small>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <div class="input-field col s12 m12 l12">
        <h5 class="center">¿La solución, producto o servicio está aún en concepto o ya hay un prototipo o versión Beta?</h5>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->txtversion_beta == 1)
                    <input class="txtversion_beta" id="version_beta_radio1" name="txtversion_beta" type="radio" value="1" checked/>
                    @else
                    <input class="txtversion_beta" id="version_beta_radio1" name="txtversion_beta" type="radio" value="1"/>
                    @endif
                @else
                <input class="txtversion_beta" id="version_beta_radio1" name="txtversion_beta" type="radio" value="1"/>
                @endif
                <label align="justify" for="version_beta_radio1" class="black-text">
                    1. <b>Concepto:</b> Algo formulado, pero no tangible
                </label>
            </p>
        </div>
    </div>
    <div class="input-field col s12 m6 l6">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->txtversion_beta == 2)
                    <input class="txtversion_beta" id="version_beta_radio2" name="txtversion_beta" type="radio" value="2" checked/>
                    @else
                    <input class="txtversion_beta" id="version_beta_radio2" name="txtversion_beta" type="radio" value="2"/>
                    @endif
                @else
                <input class="txtversion_beta" id="version_beta_radio2" name="txtversion_beta" type="radio" value="2"/>
                @endif
                <label align="justify" for="version_beta_radio2" class="black-text">
                    2. <b>Modelo en 3D:</b> Diseño de alternativa en software CAD que permite identificar la esencia del proyecto que se está presentando, con algunos detalles de concepto
                </label>
            </p>
        </div>
    </div>
    <div class="input-field col s12 m6 l6">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->txtversion_beta == 3)
                    <input class="txtversion_beta" id="version_beta_radio3" name="txtversion_beta" type="radio" value="3" checked/>
                    @else
                    <input class="txtversion_beta" id="version_beta_radio3" name="txtversion_beta" type="radio" value="3"/>
                    @endif
                @else
                <input class="txtversion_beta" id="version_beta_radio3" name="txtversion_beta" type="radio" value="3"/>
                @endif
                <label align="justify" for="version_beta_radio3" class="black-text">
                    3. <b>Prototipo:</b> Diseño en físico ya sea tamaño real, mayor o menor
                </label>
            </p>
        </div>
    </div>
    <div class="input-field col s12 m6 l6">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->txtversion_beta == 4)
                    <input class="txtversion_beta" id="version_beta_radio4" name="txtversion_beta" type="radio" value="4" checked/>
                    @else
                    <input class="txtversion_beta" id="version_beta_radio4" name="txtversion_beta" type="radio" value="4"/>
                    @endif
                @else
                <input class="txtversion_beta" id="version_beta_radio4" name="txtversion_beta" type="radio" value="4"/>
                @endif
                <label align="justify" for="version_beta_radio4" class="black-text">
                    4. <b>Versión beta:</b> Versión de prototipo final ya en pruebas con usuarios.
                </label>
            </p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col s12 m12 l12">
        <h5 class="center">Información de la Idea en la Red Tecnoparque</h5>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m12 l12">
        <i class="material-icons prefix">
            add_box
        </i>
        @if ($existe)
        <textarea class="materialize-textarea" id="txtcantidad_prototipos" length="2100" name="txtcantidad_prototipos">{{ $idea->cantidad_prototipos }}</textarea>
        @else
        <textarea class="materialize-textarea" id="txtcantidad_prototipos" length="2100" name="txtcantidad_prototipos"></textarea>
        @endif
        <label for="txtcantidad_prototipos">
            ¿Cuáles y cuántos prototipos necesita desarrollar con la Red Tecnoparques?
        </label>
        <small id="txtcantidad_prototipos-error" class="error red-text"></small>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m12 l12">
        <h5 class="center">¿En qué categoría se clasifica su idea?</h5>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta3 == 1)
                    <input class="pregunta3" id="r1" name="pregunta3" type="radio" value="1" checked/>
                    @else
                    <input class="pregunta3" id="r1" name="pregunta3" type="radio" value="1"/>
                    @endif
                @else
                <input class="pregunta3" id="r1" name="pregunta3" type="radio" value="1" checked/>
                @endif
                <label align="justify" for="r1" class="black-text">
                    1. Tecnologías Virtuales: Esta linea esta enfocada al desarrollo de aplicaciones web, móviles, inteligencia artificial, realidad aumentada, sistemas de información geográfica, seguridad informática y creación de entornos virtuales.
                </label>
            </p>
        </div>
    </div>
    <div class="input-field col s12 m6 l6">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta3 == 2) {{--  Aqui se cambiará a un nuevo valor --}}
                    <input class="pregunta3" id="r2" name="pregunta3" type="radio" value="2" checked/>
                    @else
                    <input class="pregunta3" id="r2" name="pregunta3" type="radio" value="2"/>
                    @endif
                @else
                <input class="pregunta3" id="r2" name="pregunta3" type="radio" value="2"/>
                @endif
                <label align="justify" for="r2" class="black-text">
                    2. Biotecnología y Nanotecnología: Esta linea esta enfocada al trabajo de la agroindustria alimentaria, biotecnologia vegetal, biotecnologia molecular aplicada a plantas, animales y microorganismos.
                </label>
            </p>
        </div>
    </div>
    <div class="input-field col s12 m6 l6">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta3 == 3)
                    <input class="pregunta3" id="r3" name="pregunta3" type="radio" value="3" checked/>
                    @else
                    <input class="pregunta3" id="r3" name="pregunta3" type="radio" value="3"/>
                    @endif
                @else
                <input class="pregunta3" id="r3" name="pregunta3" type="radio" value="3"/>
                @endif
                <label align="justify" for="r3" class="black-text">
                    3. Electrónica y Telecomunicaciones: Esta linea esta enfocada al internet de las cosas, automatización de procesos, sistemas embebidos, robótica, procesamiento de imágenes e instrumentación electrónica, gestión de la energía y energías renovables.
                </label>
            </p>
        </div>
    </div>
    <div class="input-field col s12 m6 l6">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta3 == 4)
                    <input class="pregunta3" id="r4" name="pregunta3" type="radio" value="4" checked/>
                    @else
                    <input class="pregunta3" id="r4" name="pregunta3" type="radio" value="4"/>
                    @endif
                @else
                <input class="pregunta3" id="r4" name="pregunta3" type="radio" value="4"/>
                @endif
                <label align="justify" for="r4" class="black-text">
                    4. Ingeniería y Diseño: Esta linea esta enfocada al diseño mecánico, diseño de productos, sistemas CAD/CAM/CAE, optimización topológica, prototipado rápido y procesos de manufactura avanzada,  ingeniería inversa  y análisis dimensiona, prototipado 3d y impresión a laser.
                </label>
            </p>
        </div>
    </div>
</div>
{{-- <div class="row">
    <div class="input-field col s12 m6 l6">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta3 == 5)
                    <input class="pregunta3" id="r5" name="pregunta3" type="radio" value="5" checked/>
                    @else
                    <input class="pregunta3" id="r5" name="pregunta3" type="radio" value="5"/>
                    @endif
                @else
                <input class="pregunta3" id="r5" name="pregunta3" type="radio" value="5"/>
                @endif
                <label align="justify" for="r5">
                    5. Nanotecnología y nuevos materiales: Modificación de superficies a escala nanométrica, síntesis de nanopartículas, evaluación a escala nanométrica, desarrollo y evaluación de nuevos materiales como materiales compuestos, materiales biodegradables y biopolímeros obtenidos a través de biotecnología.
                </label>
            </p>
        </div>
    </div>
    <div class="input-field col s12 m6 l6">
        <div class="section">
            <p class="p-v-xs">
                @if ($existe)
                    @if ($idea->pregunta3 == 6)
                    <input class="pregunta3" id="r6" name="pregunta3" type="radio" value="6" checked/>
                    @else
                    <input class="pregunta3" id="r6" name="pregunta3" type="radio" value="6"/>
                    @endif
                @else
                <input class="pregunta3" id="r6" name="pregunta3" type="radio" value="6"/>
                @endif
                <label align="justify" for="r6">
                    6. Otros Productos: personalización de productos, productos de moda, alimentos no tradicionales o exóticos, productos artesanales, construcción de infraestructura.
                </label>
            </p>
        </div>
    </div>
</div> --}}
<div class="divider"></div>
<div class="row">
    <div class="col s12 m6 l6">
        <div class="row">
            <span class="black-text text-black">
                ¿Viene de una convocatoria?
            </span>
            <div class="switch m-b-md">
                <label>
                    No
                    @if ($existe)
                        @if ($idea->viene_convocatoria == 1)
                        <input type="checkbox" name="txtviene_convocatoria" id="txtviene_convocatoria" checked value="1" onchange="showInput_Convocatoria()">
                        @else
                        <input type="checkbox" name="txtviene_convocatoria" id="txtviene_convocatoria" value="1" onchange="showInput_Convocatoria()">
                        @endif
                    @else
                    <input type="checkbox" name="txtviene_convocatoria" id="txtviene_convocatoria" value="1" onchange="showInput_Convocatoria()">
                    @endif
                    <span class="lever"></span>
                    Si
                </label>
            </div>
        </div>
        <div class="row" id="convocatoria_content">
            <div class="input-field col s12 m12 l12">
                @if ($existe)
                <input id="txtconvocatoria" name="txtconvocatoria" type="text" value="{{ $idea->convocatoria }}">
                @else
                <input id="txtconvocatoria" name="txtconvocatoria" type="text">
                @endif
                <label for="txtconvocatoria">Indique de que convocatoria viene <span class="red-text">*</span></label>
                <small id="txtconvocatoria-error" class="error red-text"></small>
            </div>
        </div>
    </div>
    <div class="col s12 m6 l6">
        <div class="row">
            <span class="black-text text-black">
                ¿La idea está avalada por una entidad?
            </span>
            <div class="switch m-b-md">
                <label>
                    No
                    @if ($existe)
                        @if ($idea->aval_empresa == 1)
                        <input type="checkbox" name="txtaval_empresa" id="txtaval_empresa" checked value="1" onchange="showInput_AvalEmpresa()">
                        @else
                        <input type="checkbox" name="txtaval_empresa" id="txtaval_empresa" value="1" onchange="showInput_AvalEmpresa()">
                        @endif
                    @else
                    <input type="checkbox" name="txtaval_empresa" id="txtaval_empresa" value="1" onchange="showInput_AvalEmpresa()">
                    @endif
                    <span class="lever"></span>
                    Si
                </label>
            </div>
        </div>
        <div class="row" id="avalEmpresa_content">
            <div class="input-field col s12 m12 l12">
                @if ($existe)
                <input id="txtempresa" name="txtempresa" type="text" value="{{ $idea->empresa }}">
                @else
                <input id="txtempresa" name="txtempresa" type="text">
                @endif
                <label for="txtempresa">Indique el nombre de la entidad <span class="red-text">*</span></label>
                <small id="txtempresa-error" class="error red-text"></small>
            </div>
        </div>
    </div>
</div>