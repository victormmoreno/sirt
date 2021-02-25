{!! csrf_field() !!}
@php
    $existe = isset($idea) ? true : false;
@endphp
<div class="card">
    <div class="card-content">
        <div class="row">
            <div class="col s12 m4 l4">
                <div class="card-panel grey lighten-1 black-text center">
                    <i class="material-icons left">info_outline</i>
                    Antes de empezar a registrar la idea de proyecto, es importante saber en que nodo se va a presentar.
                  </div>
            </div>
            <div class="input-field col s12 m8 l8">
                <i class="material-icons prefix">
                    domain
                </i>
                <select id="txtnodo" name="txtnodo" style="width: 100%" tabindex="-1">
                    <option value="">Seleccione Nodo</option>
                        @foreach($nodos as $nodo)
                            @if($existe)
                                @if ($idea->nodo_id == $nodo->id)
                                <option value="{{$nodo->id}}" selected>{{$nodo->nodos}}</option> 
                                @else
                                <option value="{{$nodo->id}}">{{$nodo->nodos}}</option> 
                                @endif
                            @else
                            <option value="{{$nodo->id}}">
                                {{$nodo->nodos}}
                            </option>
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
            <span class="black-text text-black">¿Esta idea será desarrollada por una empresa?</span>
            <div class="switch m-b-md">
                <label>
                    No
                    @if ($existe)
                        @if ($idea->empresa_id != null)
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
        <div class="row" id="buscarEmpresa_content">
            <div class="input-field col s8 m8 l8">
                @if ($existe)
                    @if ($idea->empresa_id != null)
                    <input type="text" id="txtnit" name="txtnit" value="{{ $idea->company->nit }}">
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
        </div>
        <div class="card-panel green lighten-5" id="consultarEmpresa_content">
            <div class="divider"></div>
            <h4 class="center">Empresa registrada</h4>
            @include('empresa.detalle_registrado')
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
                    ¿De qué se trata la solución y/o idea de negocio?
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
        <div class="divider"></div>
        <div class="row">
            <div class="input-field col s12 m12 l12">
                <h5 class="center">Estado actual la solución y/o idea de negocio</h5>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <div class="section">
                    <p class="p-v-xs">
                        @if ($existe)
                            @if ($idea->pregunta1 == 1)
                            <input class="pregunta1" id="radio1" name="pregunta1" type="radio" value="1" checked/>
                            @else
                            <input class="pregunta1" id="radio1" name="pregunta1" type="radio" value="1"/>
                            @endif
                        @else
                        <input class="pregunta1" id="radio1" name="pregunta1" type="radio" value="1" checked/>
                        @endif
                        <label align="justify" for="radio1">
                            1. Tengo el problema identificado, pero no tengo claro que producto debo desarrollar para resolverlo.
                        </label>
                    </p>
                </div>
            </div>
            <div class="input-field col s12 m6 l6">
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
                        <label align="justify" for="radio2">
                            2. Tengo la idea del producto que quiero desarrollar pero no sé cómo hacerlo.
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6 l6">
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
                        <label align="justify" for="radio3">
                            3. Tengo la idea del producto que quiero desarrollar, tengo los conocimientos para hacerlo, pero no se qué pasos seguir para formular el proyecto.
                        </label>
                    </p>
                </div>
            </div>
            <div class="input-field col s12 m6 l6">
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
                        <label align="justify" for="radio4">
                            4. Tengo formulado el proyecto para desarrollar mi producto: tengo claros los objetivos, el alcance, los recursos y las actividades que debo realizar para conseguirlo, entre otros.
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6 l6">
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
                        <label align="justify" for="radio5">
                            5. Mi proyecto está formulado y ya comencé la ejecución, pero necesito gestionar algunos recursos para poder avanzar.
                        </label>
                    </p>
                </div>
            </div>
            <div class="input-field col s12 m6 l6">
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
                        <label align="justify" for="radio6">
                            6. Ya tengo un prototipo avanzado de mi producto y requiero gestionar algunos recursos para concluir mi proyecto.
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <div class="section">
                    <p class="p-v-xs">
                        @if ($existe)
                            @if ($idea->pregunta1 == 7)
                            <input class="pregunta1" id="radio7" name="pregunta1" type="radio" value="7" checked/>
                            @else
                            <input class="pregunta1" id="radio7" name="pregunta1" type="radio" value="7"/>
                            @endif
                        @else
                        <input class="pregunta1" id="radio7" name="pregunta1" type="radio" value="7"/>
                        @endif
                        <label align="justify" for="radio7">
                            7. Ya tengo un prototipo final, he realizado pruebas y ajustes, tengo planteada la idea de negocio y requiero gestionar algunos recursos para implementarla.
                        </label>
                    </p>
                </div>
            </div>
            <div class="input-field col s12 m6 l6">
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
                        <label align="justify" for="radio8">
                            8. No voy a desarrollar un producto, voy a comercializar un producto de otro fabricante.
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6 l6">
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
                        <label align="justify" for="radio9">
                            9. Quiero desarrollar una página web para promocionar mi negocio actual.
                        </label>
                    </p>
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
            <div class="input-field col s12 m6 l6">
                <i class="material-icons prefix">
                    payment
                </i>
                @if ($existe)
                <textarea class="materialize-textarea" id="txtquien_compra" length="1400" name="txtquien_compra">{{ $idea->quien_compra }}</textarea>
                @else
                <textarea class="materialize-textarea" id="txtquien_compra" length="1400" name="txtquien_compra"></textarea>
                @endif
                <label for="txtquien_compra">
                    ¿Quién comprará la solución, producto o servicio? 
                </label>
                <small id="txtquien_compra-error" class="error red-text"></small>
            </div>
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
        </div>
        <div class="divider"></div>
        <div class="row">
            <div class="input-field col s12 m12 l12">
                <h5 class="center">Canales</h5>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6 l6">
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
            </div>
            <div class="input-field col s12 m6 l6">
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
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6 l6">
                <div class="row">
                    <span class="black-text text-black">¿El producto o servicio requiere algún tipo de packing?</span>
                    <div class="switch m-b-md">
                        <label>
                            No
                            @if ($existe)
                                @if ($idea->packing == 1)
                                <input type="checkbox" name="txtpacking" id="txtpacking" checked value="1" onchange="showInput_Packing()">
                                @else
                                <input type="checkbox" name="txtpacking" id="txtpacking" value="1" onchange="showInput_Packing()">
                                @endif
                            @else
                            <input type="checkbox" name="txtpacking" id="txtpacking" value="1" onchange="showInput_Packing()">
                            @endif
                            <span class="lever"></span>
                            Si
                        </label>
                    </div>
                </div>
                <div class="row" id="packing_content">
                    <div class="input-field col s12 m12 l12">
                        @if ($existe)
                        <textarea class="materialize-textarea" id="txttipo_packing" length="1400" name="txttipo_packing">{{ $idea->tipo_packing }}</textarea>
                        @else
                        <textarea class="materialize-textarea" id="txttipo_packing" length="1400" name="txttipo_packing"></textarea>
                        @endif
                        <label for="txttipo_packing">Indique cuál es el tipo de packing que se requiere <span class="red-text">*</span></label>
                        <small id="txttipo_packing-error" class="error red-text"></small>
                    </div>
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
            <div class="input-field col s12 m6 l6">
                <i class="material-icons prefix">
                    credit_card
                </i>
                @if ($existe)
                <textarea class="materialize-textarea" id="txtmedio_venta" length="2100" name="txtmedio_venta">{{ $idea->medio_venta }}</textarea>
                @else
                <textarea class="materialize-textarea" id="txtmedio_venta" length="2100" name="txtmedio_venta"></textarea>
                @endif
                <label for="txtmedio_venta">
                    ¿Por qué medio se venderá el producto o servicio desarrollado?  
                </label>
                <small id="txtmedio_venta-error" class="error red-text"></small>
            </div>
            <div class="input-field col s12 m6 l6">
                <i class="material-icons prefix">
                    monetization_on
                </i>
                @if ($existe)
                <textarea class="materialize-textarea" id="txtvalor_clientes" length="2100" name="txtvalor_clientes">{{ $idea->valor_clientes }}</textarea>
                @else
                <textarea class="materialize-textarea" id="txtvalor_clientes" length="2100" name="txtvalor_clientes"></textarea>
                @endif
                <label for="txtvalor_clientes">
                    ¿Por qué valor están dispuestos a pagar nuestros clientes?
                </label>
                <small id="txtvalor_clientes-error" class="error red-text"></small>
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
                        <input class="pregunta2" id="rad1" name="pregunta2" type="radio" value="1" checked/>
                        @endif
                        <label align="justify" for="rad1">
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
                        <label align="justify" for="rad2">
                            2. Tengo un equipo de trabajo que cuenta con los conocimientos técnicos mínimos para el desarrollo del producto, pero no contamos con los conocimientos de mercadeo para la implementación de la idea de negocio.
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
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
                        <label align="justify" for="rad3">
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
                        <label align="justify" for="rad4">
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
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <i class="material-icons prefix">
                    gavel
                </i>
                @if ($existe)
                <textarea class="materialize-textarea" id="txtforma_juridica" length="1400" name="txtforma_juridica">{{ $idea->forma_juridica }}</textarea>
                @else
                <textarea class="materialize-textarea" id="txtforma_juridica" length="1400" name="txtforma_juridica"></textarea>
                @endif
                <label for="txtforma_juridica">
                    ¿Qué forma jurídica va a tener el negocio y por qué?  
                </label>
                <small id="txtforma_juridica-error" class="error red-text"></small>
            </div>
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
            <div class="col s12 m12 l12">
                <h5 class="center">Información de la Idea en la Red Tecnoparque</h5>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <i class="material-icons prefix">
                    important_devices
                </i>
                @if ($existe)
                <input id="txtversion_beta" name="txtversion_beta" type="text" value="{{$idea->version_beta}}">
                @else
                <input id="txtversion_beta" name="txtversion_beta" type="text">
                @endif
                <label for="txtversion_beta">
                    ¿La solución, producto o servicio está aún en concepto o ya hay un prototipo o versión Beta?
                </label>
                <small id="txtversion_beta-error" class="error red-text"></small>
            </div>
            <div class="col s12 m6 l6">
                <div class="row">
                    <span class="black-text text-black">
                        ¿Se dispone de recursos para el desarrollo de los prototipos necesarios?
                    </span>
                    <div class="switch m-b-md">
                        <label>
                            No
                            @if ($existe)
                                @if ($idea->recursos_necesarios == 1)
                                <input type="checkbox" name="txtrecursos_necesarios" id="txtrecursos_necesarios" checked value="1" onchange="showInput_Recursos()">
                                @else
                                <input type="checkbox" name="txtrecursos_necesarios" id="txtrecursos_necesarios" value="1" onchange="showInput_Recursos()">
                                @endif
                            @else
                            <input type="checkbox" name="txtrecursos_necesarios" id="txtrecursos_necesarios" value="1" onchange="showInput_Recursos()">
                            @endif
                            <span class="lever"></span>
                            Si
                        </label>
                    </div>
                </div>
                <div class="row" id="recursos_content">
                    <div class="input-field col s12 m12 l12">
                        @if ($existe)
                        <textarea class="materialize-textarea" id="txtsi_recursos_necesarios" length="2100" name="txtsi_recursos_necesarios">{{ $idea->si_recursos_necesarios }}</textarea>
                        @else
                        <textarea class="materialize-textarea" id="txtsi_recursos_necesarios" length="2100" name="txtsi_recursos_necesarios"></textarea>
                        @endif
                        <label for="txtsi_recursos_necesarios">Indique cuales son esos recursos que se disponen<span class="red-text">*</span></label>
                        <small id="txtsi_recursos_necesarios-error" class="error red-text"></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6 l6">
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
                        <label align="justify" for="r1">
                            1. Tecnologías Virtuales: desarrollo de software para diferentes dispositivos, animaciones 2D y 3D, creación de contenidos para aplicaciones, animaciones y videojuegos.
                        </label>
                    </p>
                </div>
            </div>
            <div class="input-field col s12 m6 l6">
                <div class="section">
                    <p class="p-v-xs">
                        @if ($existe)
                            @if ($idea->pregunta3 == 2)
                            <input class="pregunta3" id="r2" name="pregunta3" type="radio" value="2" checked/>
                            @else
                            <input class="pregunta3" id="r2" name="pregunta3" type="radio" value="2"/>
                            @endif
                        @else
                        <input class="pregunta3" id="r2" name="pregunta3" type="radio" value="2"/>
                        @endif
                        <label align="justify" for="r2">
                            2. Biotecnología: utilización de organismos vivos o sus derivados para el desarrollo de productos y/o procesos en las áreas de ambiente, alimentos y nanotecnología.
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
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
                        <label align="justify" for="r3">
                            3. Electrónica y Telecomunicaciones: Control de procesos, telecomunicaciones, automatización, robótica aplicada, sistemas embebidos, prototipado electrónico y televisión digital.
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
                        <label align="justify" for="r4">
                            4. Ingeniería y Diseño: diseño de productos en las áreas afines a la mecánica y el diseño industrial, como aprovechamiento de energías renovables, máquinas,mobiliario, consumo masivo y empaques.
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
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
        </div>
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
                        ¿La idea está avalada por una empresa?
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
                        <input id="txtempresa" name="txtempresa" type="text" value="{{ $idea->empresa }}"">
                        @else
                        <input id="txtempresa" name="txtempresa" type="text">
                        @endif
                        <label for="txtempresa">Indique el nombre de la empresa <span class="red-text">*</span></label>
                        <small id="txtempresa-error" class="error red-text"></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="divider"></div>
        <center>
            <button type="submit" class="waves-effect cyan darken-1 btn center-aling">
                <i class="material-icons right">{{ isset($btnText) ? $btnText == 'Modificar' ? 'done' : 'done_all' : '' }}</i>
                {{$btnText}}
            </button>   
            <a href="{{route('idea.index')}}" class="waves-effect red lighten-2 btn center-aling">
                <i class="material-icons right">backspace</i>Cancelar
            </a>
        </center>
    </div>
</div>