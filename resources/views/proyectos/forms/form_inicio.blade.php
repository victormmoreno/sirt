{!! csrf_field() !!}
@php
    $existe = isset($proyecto) ? true : false;
@endphp
<div class="col s12 m12 l12 m-b-lg">
    <div class="card-content bg-info white-text">
    <p>
        <i class="material-icons left">info_outline</i>
        Los elementos con (*) son obligatorios
    </p>
    </div>
</div>
<br>
@if (session()->get('login_role') == App\User::IsAdministrador() && Route::currentRouteName() == ('proyecto.create'))
    <div class="row">
        <div class="input-field col s12 m4 l4">
            <select style="width: 100%" class="js-states" id="txtnodo_id" name="txtnodo_id" onchange="consultarExpertosDeUnNodo(this.value);">
            <option value="">Seleccione el nodo del experto</option>
            @if ($existe)
                @forelse ($nodos as $id => $nodo)
                <option value={{$id}} {{ $proyecto->asesor->user_nodo->nodo_id == $id ? 'selected' : '' }}>{{$nodo->nodos}}</option>
                @empty
                <option value=""> No hay información disponible</option>
                @endforelse
            @else
                @forelse ($nodos as $id => $nodo)
                <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                @empty
                <option value=""> No hay información disponible</option>
                @endforelse
            @endif
        </select>
        </div>
        <div class="input-field col s12 m4 l4">
            <select style="width: 100%" class="js-states" id="txtexperto_id_proyecto" name="txtexperto_id_proyecto" onchange="consultarInformacionExperto(this.value);">
            <option value="">Seleccione el experto</option>
        </select>
        </div>
        <div class="input-field col s12 m4 l4">
            <input disabled id="txtlinea" name="txtlinea" value="Debes seleccionar un experto" type="text">
            <label for="txtlinea" class="">Línea Tecnológica</label>
        </div>
    </div>
@else
    @if ($existe)
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <input disabled id="txtgestor" name="txtgestor"
                    value="{{ $proyecto->asesor->nombres }} {{ $proyecto->asesor->apellidos }}" type="text">
                <label for="txtgestor" class="">Experto</label>
            </div>
            <div class="input-field col s12 m6 l6">
                <input disabled id="txtlinea" name="txtlinea" value="{{ $proyecto->asesor->experto->linea->nombre }}"
                    type="text">
                <label for="txtlinea" class="">Línea Tecnológica</label>
            </div>
        </div>
    @else
        <div class="row">
            <div class="input-field col s12 m6 l6">
                <input disabled id="txtgestor" name="txtgestor" value="{{ auth()->user()->nombres }} {{ auth()->user()->apellidos }}" type="text">
                <label for="txtgestor" class="">Experto</label>
            </div>
            <div class="input-field col s12 m6 l6">
                <input disabled id="txtlinea" name="txtlinea" value=""
                    type="text">
                <label for="txtlinea" class="">Línea Tecnológica</label>
            </div>
        </div>
    @endif
@endif
<div class="row">
    <h5 class="center primary-text"><i class="material-icons">lightbulb</i>Idea de Proyecto.</h5>
</div>
<div class="divider"></div>
<div class="row">
    <div class="col s12 m6 l6 offset-l3 m3">
        <div class="center-align">
            <div class="card-panel grey lighten-3">
                <div class="row">
                    <div class="input-field col s12 m12 l12">
                        @if ($existe)
                            <input type="text" id="txtnombreIdeaProyecto_Proyecto" name="txtnombreIdeaProyecto_Proyecto" value="{{ $proyecto->idea->codigo_idea . ' - ' . $proyecto->idea->nombre_proyecto }}" readonly>
                        @else
                            <input type="text" id="txtnombreIdeaProyecto_Proyecto" name="txtnombreIdeaProyecto_Proyecto" readonly>
                        @endif
                        <label for="txtnombreIdeaProyecto_Proyecto">Idea de Proyecto</label>
                        <small id="txtidea_id-error" class="error red-text"></small>
                    </div>
                    @if (!$existe)
                        <a class="btn-flat bg-secondary white-text" onclick="consultarIdeasDeProyectoEmprendedores_Proyecto_FaseInicio();">
                            <i class="material-icons left">search</i>Buscar
                        </a>
                    @endif
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l12">
                        @if ($existe)
                            <input type="text" id="txtnombre" name="txtnombre" value="{{ $proyecto->nombre }}">
                        @else
                            <input type="text" id="txtnombre" name="txtnombre" value="">
                        @endif
                        <label for="txtnombre">Nombre de Proyecto <span class="red-text">*</span></label>
                        <small id="txtnombre-error" class="error red-text"></small>
                    </div>
                </div>
            </div>
        </div>
        @if ($existe)
        <input type="hidden" name="txtidea_id" id="txtidea_id" value="{{ $proyecto->idea->id }}">
        @else
        <input type="hidden" name="txtidea_id" id="txtidea_id" value="">
        @endif
    </div>
</div>

<div class="row">
    <h5 class="center primary-text">Datos del proyecto.</h5>
</div>
<div class="divider"></div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        @if ($existe)
        <select style="width: 100%" class="js-states" id="txtareaconocimiento_id" name="txtareaconocimiento_id"
            onchange="selectAreaConocimiento_Proyecto_FaseInicio();">
            <option value="">Seleccione el área de conocimiento</option>
            @forelse ($areasconocimiento as $id => $value)
            <option value="{{$id}}" {{ $proyecto->areaconocimiento_id == $id ? 'selected' : '' }}>{{$value}}</option>
            @empty
            <option value=""> No hay información disponible</option>
            @endforelse
        </select>
        @else
        <select style="width: 100%" class="js-states" id="txtareaconocimiento_id" name="txtareaconocimiento_id"
            onchange="selectAreaConocimiento_Proyecto_FaseInicio();">
            <option value="">Seleccione el área de conocimiento</option>
            @forelse ($areasconocimiento as $id => $value)
            <option value="{{$id}}">{{$value}}</option>
            @empty
            <option value=""> No hay información disponible</option>
            @endforelse
        </select>
        @endif
        <label for="txtareaconocimiento_id">Áreas de Conocimiento <span class="red-text">*</span></label>
        <small id="txtareaconocimiento_id-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12 m6 l6">
        @if ($existe)
        <select id="txtsublinea_id" class="js-states" name="txtsublinea_id" style="width: 100%">
            <option value="">Seleccione la Sublínea</option>
            @forelse ($sublineas as $key => $value)
            <option value="{{$key}}" {{ $proyecto->sublinea_id == $key ? 'selected' : '' }}>{{$value}}</option>
            @empty
            <option value="">No hay información disponible</option>
            @endforelse
        </select>
        @else
        <select id="txtsublinea_id" class="js-states" name="txtsublinea_id" style="width: 100%">
            <option value="">Seleccione la Sublínea</option>
            @if ($sublineas != null)
                @forelse ($sublineas as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
                @empty
                <option value="">No hay información disponible</option>
                @endforelse
            @else
                <option value="">No hay información disponible</option>
            @endif
        </select>
        @endif
        <label for="txtsublinea_id">Sublínea <span class="red-text">*</span></label>
        <small id="txtsublinea_id-error" class="error red-text"></small>
    </div>
</div>
<div class="row" id="otroAreaConocimiento_content">
    <div class="input-field col s12 m12 l12">
        @if ($existe)
        <input type="text" id="txtotro_areaconocimiento" name="txtotro_areaconocimiento" value="{{ $proyecto->otro_areaconocimiento }}">
        @else
        <input type="text" id="txtotro_areaconocimiento" name="txtotro_areaconocimiento" value="">
        @endif
        <label for="txtotro_areaconocimiento">Otro área de conocimiento. <span class="red-text">*</span></label>
        <small id="txtotro_areaconocimiento-error" class="error red-text"></small>
    </div>
</div>
<div class="row">
    <div class="col s12 m4 l4">
        <span class="black-text text-black">TRL que se pretende realizar</span>
        <div class="switch m-b-md">
            <label>
                TRL 6
                @if ($existe)
                <input type="checkbox" name="trl_esperado" id="trl_esperado" value="1" {{ $proyecto->trl_esperado == 0 ? '' : 'checked' }}>
                @else
                <input type="checkbox" name="trl_esperado" id="trl_esperado" value="1">
                @endif
                <span class="lever"></span>
                TRL 7 - TRL 8
            </label>
        </div>
    </div>
    <div class="col s12 m4 l4">
        <span class="black-text text-black">¿Recibido a través de fábrica de productividad?</span>
        <div class="switch m-b-md">
            <label>
                No
                @if ($existe)
                <input type="checkbox" name="txtfabrica_productividad" id="txtfabrica_productividad" value="1" {{ $proyecto->fabrica_productividad == 0 ? '' : 'checked' }}>
                @else
                <input type="checkbox" name="txtfabrica_productividad" id="txtfabrica_productividad" value="1">
                @endif
                <span class="lever"></span>
                Si
            </label>
        </div>
    </div>
    <div class="col s12 m4 l4">
        <span class="black-text text-black">¿Recibido a través del área de emprendimiento SENA?</span>
        <div class="switch m-b-md">
            <label>
                No
                @if ($existe)
                <input type="checkbox" name="txtreci_ar_emp" id="txtreci_ar_emp" value="1" {{ $proyecto->reci_ar_emp == 0 ? '' : 'checked' }}>
                @else
                <input type="checkbox" name="txtreci_ar_emp" id="txtreci_ar_emp" value="1">
                @endif
                <span class="lever"></span>
                Si
            </label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col s12 m4 l4">
        <div class="row">
            <span class="black-text text-black">¿El proyecto pertenece a la economía naranja?</span>
            <div class="switch m-b-md">
                <label>
                    No
                    @if ($existe)
                    <input type="checkbox" name="txteconomia_naranja" id="txteconomia_naranja" value="1" {{ $proyecto->economia_naranja == 0 ? '' : 'checked' }} onchange="showInput_EconomiaNaranja()">
                    @else
                    <input type="checkbox" name="txteconomia_naranja" id="txteconomia_naranja" value="1" onchange="showInput_EconomiaNaranja()">
                    @endif
                    <span class="lever"></span>
                    Si
                </label>
            </div>
        </div>
        <div class="row" id="economiaNaranja_content">
            <div class="input-field col s12 m12 l12">
                @if ($existe)
                <input type="text" id="txttipo_economianaranja" name="txttipo_economianaranja" value="{{ $proyecto->tipo_economianaranja }}">
                @else
                <input type="text" id="txttipo_economianaranja" name="txttipo_economianaranja" value="">
                @endif
                <label for="txttipo_economianaranja">Tipo de Proyecto de Economía Naranja. <span class="red-text">*</span></label>
                <small id="txttipo_economianaranja-error" class="error red-text"></small>
            </div>
        </div>
    </div>
    <div class="col s12 m4 l4">
        <div class="row">
            <span class="black-text text-black">¿El proyecto está dirigido a discapacitados?</span>
            <div class="switch m-b-md">
                <label>
                    No
                    @if ($existe)
                    <input type="checkbox" name="txtdirigido_discapacitados" id="txtdirigido_discapacitados" value="1" {{ $proyecto->dirigido_discapacitados == 0 ? '' : 'checked' }} onchange="showInput_Discapacidad()">
                    @else
                    <input type="checkbox" name="txtdirigido_discapacitados" id="txtdirigido_discapacitados" value="1" onchange="showInput_Discapacidad()">
                    @endif
                    <span class="lever"></span>
                    Si
                </label>
            </div>
        </div>
        <div class="row" id="discapacidad_content">
            <div class="input-field col s12 m12 l12">
                @if ($existe)
                <input type="text" id="txttipo_discapacitados" name="txttipo_discapacitados" value="{{ $proyecto->tipo_discapacitados }}">
                @else
                <input type="text" id="txttipo_discapacitados" name="txttipo_discapacitados" value="">
                @endif
                <label for="txttipo_discapacitados">Tipo de Discapacitados. <span class="red-text">*</span></label>
                <small id="txttipo_discapacitados-error" class="error red-text"></small>
            </div>
        </div>
    </div>
    <div class="col s12 m4 l4">
        <div class="row">
            <span class="black-text text-black">Articulado con CT+i</span>
            <div class="switch m-b-md">
                <label>
                    No
                    @if ($existe)
                    <input type="checkbox" name="txtarti_cti" id="txtarti_cti" value="1" {{ $proyecto->art_cti == 0 ? '' : 'checked' }} onchange="showInput_ActorCTi()">
                    @else
                    <input type="checkbox" name="txtarti_cti" id="txtarti_cti" value="1" onchange="showInput_ActorCTi()">
                    @endif
                    <span class="lever"></span>
                    Si
                </label>
            </div>
        </div>
        <div class="row" id="nombreActorCTi_content">
            <div class="input-field col s12 m12 l12">
                @if ($existe)
                <input type="text" name="txtnom_act_cti" id="txtnom_act_cti" value="{{ $proyecto->nom_act_cti }}">
                @else
                <input type="text" name="txtnom_act_cti" id="txtnom_act_cti" value="">
                @endif
                <label for="txtnom_act_cti">Nombre del Actor CT+i <span class="red-text">*</span></label>
                <small id="txtnom_act_cti-error" class="error red-text"></small>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <h5 class="center primary-text"><i class="material-icons">bookmark</i>Etiquetas de proyecto (Seleccionar 1 o más de una)</h5>
    @if ($existe)
        @forelse ($proyecto->SelectedTags() as $tag)
            @if ($tag->tagged == 1)
                <label class="waves-effect waves-light btn tooltipped" data-position="bottom" data-tooltip="{{$tag->description}}">
                <input type="checkbox" name="tags[]" checked value="{{$tag->id}}" />{{$tag->name}}</label>
            @else
                <label class="waves-effect waves-light btn btn-flat tooltipped" data-position="bottom" data-tooltip="{{$tag->description}}">
                <input type="checkbox" name="tags[]" value="{{$tag->id}}" />{{$tag->name}}</label>
            @endif
        @empty
            <p>No hay etiquetas activas en el momento</p>
        @endforelse
    @else
        @forelse ($tags as $tag)
            <label class="waves-effect waves-light btn btn-flat tooltipped" data-position="bottom" data-tooltip="{{$tag->description}}">
            <input type="checkbox" name="tags[]" value="{{$tag->id}}" />{{$tag->name}}</label>
        @empty
            <p>No hay etiquetas activas en el momento</p>
        @endforelse
    @endif
</div>
<div class="row center">
    <small id="tags-error" class="error red-text"></small>
</div>
<div class="row">
    <h5 class="center primary-text"><i class="material-icons">supervised_user_circle</i>Talentos que participarán en el proyecto</h5>
</div>
<div class="divider"></div>
<div class="row">
    <div class="col s12 m12 l12">
        <div class="card-content">
            <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header active primary-text"><i class="material-icons">people</i>
                        Pulse aquí para ver la información de los talentos.
                    </div>
                    <div class="collapsible-body">
                        <div class="card-content">
                            @if ($existe)
                                @if ($proyecto->present()->proyectoFase() == 'Inicio')
                                <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                                    <li>
                                        <div class="collapsible-header bg-info white-text"><i class="material-icons">group_add</i>
                                            Pulse aquí para ver los talentos y asociarlos al proyecto.</div>
                                        <div class="collapsible-body">
                                            <div class="card-content">
                                                <div class="row">
                                                    <table id="talentosDeTecnoparque_Proyecto_FaseInicio_table" style="width: 100%">
                                                        <thead class="bg-primary white-text">
                                                            <th>Documento de Identidad</th>
                                                            <th>Nombres del Talento</th>
                                                            <th>Asociar al Proyecto</th>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                @endif
                            @else
                            <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                                <li>
                                    <div class="collapsible-header bg-info white-text"><i class="material-icons">group_add</i>
                                        Pulse aquí para ver los talentos y asociarlos al proyecto.
                                    </div>
                                    <div class="collapsible-body">
                                        <div class="card-content">
                                            <div class="row">
                                                <table id="talentosDeTecnoparque_Proyecto_FaseInicio_table" style="width: 100%">
                                                    <thead class="bg-primary white-text">
                                                        <th>Documento de Identidad</th>
                                                        <th>Nombres del Talento</th>
                                                        <th>Asociar al Proyecto</th>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            @endif
                            <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                                <li>
                                    <div class="collapsible-header active bg-success white-text"><i class="material-icons">how_to_reg</i>
                                        Pulse aquí para la información de los talentos asociados al proyecto.
                                    </div>
                                    <div class="collapsible-body">
                                        <div class="card-content">
                                            <div class="row">
                                                <table id="detalleTalentosDeUnProyecto_Create" class="striped">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 15%">Talento Interlocutor</th>
                                                            <th style="width: 40%">Talento</th>
                                                            @if ($existe)
                                                                @if ($proyecto->present()->proyectoFase() == 'Inicio')
                                                                <th style="width: 20%">Eliminar</th>
                                                                @endif
                                                            @else
                                                                <th style="width: 20%">Eliminar</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($existe)
                                                            @foreach ($proyecto->talentos as $key => $value)
                                                                <tr id="talentoAsociadoAProyecto{{$value->id}}">
                                                                <td><input type="radio" class="with-gap" {{$value->pivot->talento_lider == 1 ? 'checked' : ''}} name="radioTalentoLider" id="radioButton'{{$value->id}}'" value="{{$value->id}}"/><label for ="radioButton'{{$value->id}}'"></label></td>
                                                                <td><input type="hidden" name="talentos[]" value="{{$value->id}}">{{$value->documento}} - {{$value->nombres}} {{$value->apellidos}}</td>
                                                                @if ($proyecto->present()->proyectoFase() == 'Inicio')
                                                                <td><a class="waves-effect bg-danger white-text btn" onclick="eliminarTalentoDeProyecto_FaseInicio({{$value->id}});"><i class="material-icons">delete_sweep</i></a></td>
                                                                @endif
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="talentos-error" class="error red-text"></div>
                                            <div id="radioTalentoLider-error" class="error red-text"></div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<h5 class="center primary-text">Objetivos y alcance del proyecto.</h5>
<div class="divider"></div>
<div class="row">
    <div class="col s12 m6 l6">
        <div class="input-field col s12 m12 l12">
            @if ($existe)
            <textarea name="txtobjetivo" class="materialize-textarea" length="500" maxlength="500" id="txtobjetivo">{{ $proyecto->objetivo_general }}</textarea>
            @else
            <textarea name="txtobjetivo" class="materialize-textarea" length="500" maxlength="500" id="txtobjetivo"></textarea>
            @endif
            <label for="txtobjetivo">Objetivo General del Proyecto <span class="red-text">*</span></label>
            <small id="txtobjetivo-error" class="error red-text"></small>
        </div>
    </div>
    <div class="col s12 m6 l6">
        <div class="input-field col s12 m12 l12">
            @if ($existe)
            <textarea name="txtalcance_proyecto" class="materialize-textarea" length="1000" maxlength="1000" id="txtalcance_proyecto">{{ $proyecto->alcance_proyecto }}</textarea>
            @else
            <textarea name="txtalcance_proyecto" class="materialize-textarea" length="1000" maxlength="1000" id="txtalcance_proyecto"></textarea>
            @endif
            <label for="txtalcance_proyecto">Alcance del proyecto <span class="red-text">*</span></label>
            <small id="txtalcance_proyecto-error" class="error red-text"></small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col s12 m12 l12">
        <div class="input-field col s12 m12 l12">
            @if ($existe)
            <input type="text" id="txtobjetivo_especifico1" name="txtobjetivo_especifico1" value="{{$proyecto->objetivos_especificos[0]->objetivo}}">
            @else
            <input type="text" id="txtobjetivo_especifico1" name="txtobjetivo_especifico1" value="">
            @endif
            <label for="txtobjetivo_especifico1">Primer Objetivo Específico <span class="red-text">*</span></label>
            <small id="txtobjetivo_especifico1-error" class="error red-text"></small>
        </div>
        <div class="input-field col s12 m12 l12">
            @if ($existe)
            <input type="text" id="txtobjetivo_especifico2" name="txtobjetivo_especifico2" value="{{ $proyecto->objetivos_especificos[1]->objetivo }}">
            @else
            <input type="text" id="txtobjetivo_especifico2" name="txtobjetivo_especifico2" value="">
            @endif
            <label for="txtobjetivo_especifico2">Segundo Objetivo Específico <span class="red-text">*</span></label>
            <small id="txtobjetivo_especifico2-error" class="error red-text"></small>
        </div>
        <div class="input-field col s12 m12 l12">
            @if ($existe)
            <input type="text" id="txtobjetivo_especifico3" name="txtobjetivo_especifico3" value="{{ $proyecto->objetivos_especificos[2]->objetivo }}">
            @else
            <input type="text" id="txtobjetivo_especifico3" name="txtobjetivo_especifico3" value="">
            @endif
            <label for="txtobjetivo_especifico3">Tercer Objetivo Específico <span class="red-text">*</span></label>
            <small id="txtobjetivo_especifico3-error" class="error red-text"></small>
        </div>
        <div class="input-field col s12 m12 l12">
            @if ($existe)
            <input type="text" id="txtobjetivo_especifico4" name="txtobjetivo_especifico4" value="{{ $proyecto->objetivos_especificos[3]->objetivo }}">
            @else
            <input type="text" id="txtobjetivo_especifico4" name="txtobjetivo_especifico4" value="">
            @endif
            <label for="txtobjetivo_especifico4">Cuarto Objetivo Específico <span class="red-text">*</span></label>
            <small id="txtobjetivo_especifico4-error" class="error red-text"></small>
        </div>
    </div>
</div>
<h5 class="center primary-text">Datos de la propiedad intelectual.</h5>
<div class="divider"></div>
<div class="row">
    <div class="col s12 m4 l4">
        <div class="card-panel green lighten-5">
            <div class="row">
                <h5 class="center">Talentos dueños de la propiedad intelectual.</h5>
            </div>
            @if ($existe)
                <div class="row center">
                    <a class="btn btn-medium green" onclick="consultarTalentosDeTecnoparque_Proyecto_FaseInicio_table('#posiblesPropietarios_Personas_table', 'add_propiedad');">
                        Agregar
                    </a>
                </div>
            @else
            <div class="row center">
                <a class="btn btn-medium green" onclick="consultarTalentosDeTecnoparque_Proyecto_FaseInicio_table('#posiblesPropietarios_Personas_table', 'add_propiedad');">
                    Agregar
                </a>
            </div>
            @endif
            <table id="propiedadIntelectual_Personas">
                <thead>
                    <tr>
                        <th style="width: 80%">Propietario de la Propiedad Intelectual.</th>
                        @if ($existe)
                            <th style="width: 20%">Eliminar</th>
                        @else
                            <th style="width: 20%">Eliminar</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if ($existe)
                        @foreach ($proyecto->users_propietarios as $key => $value)
                            <tr id="propietarioAsociadoAlProyecto_Persona{{$value->id}}">
                            <td><input type="hidden" name="propietarios_user[]" value="{{$value->id}}">{{$value->documento}} - {{$value->nombres}} {{$value->apellidos}}</td>
                            @if ($proyecto->present()->proyectoFase() == 'Inicio')
                            <td><a class="waves-effect bg-danger white-text btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Persona({{$value->id}});"><i class="material-icons">delete_sweep</i></a></td>
                            @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="col s12 m4 l4">
        <div class="card-panel blue lighten-5">
            <div class="row">
                <h5 class="center">Empresas dueñas de la propiedad intelectual.</h5>
            </div>
            @if ($existe)
                @if ($proyecto->present()->proyectoFase() == 'Inicio')
                    <div class="row center">
                        <a class="btn btn-medium blue" onclick="consultarEmpresasDeTecnoparque_Proyecto_FaseInicio_table();">
                            Agregar
                        </a>
                    </div>
                 @endif
            @else
                <div class="row center">
                    <a class="btn btn-medium blue" onclick="consultarEmpresasDeTecnoparque_Proyecto_FaseInicio_table();">
                        Agregar
                    </a>
                </div>
            @endif
            <table id="propiedadIntelectual_Empresas">
                <thead>
                    <tr>
                        <th style="width: 80%">Nit y nombre de la empresa</th>
                        @if ($existe)
                            @if ($proyecto->present()->proyectoFase() == 'Inicio')
                            <th style="width: 20%">Eliminar</th>
                            @endif
                        @else
                            <th style="width: 20%">Eliminar</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if ($existe)
                        @foreach ($proyecto->sedes as $key => $value)
                            <tr id="propietarioAsociadoAlProyecto_Empresa{{$value->id}}">
                            <td><input type="hidden" name="propietarios_sedes[]" value="{{$value->id}}">{{$value->empresa->nit}} - {{ $value->empresa->nombre }} ({{$value->nombre_sede}})</td>
                            @if ($proyecto->present()->proyectoFase() == 'Inicio')
                            <td><a class="waves-effect bg-danger white-text btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Empresa({{$value->id}});"><i class="material-icons">delete_sweep</i></a></td>
                            @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <!-- <small id="propietarios_entidad-error" class="error red-text"></small> -->
        </div>
    </div>
    <div class="col s12 m4 l4">
        <div class="card-panel teal lighten-5">
            <div class="row">
                <h5 class="center">Grupos de investigación dueños de la propiedad intelectual.</h5>
            </div>
            @if ($existe)
                @if ($proyecto->present()->proyectoFase() == 'Inicio')
                    <div class="row center">
                        <a class="btn btn-medium teal" onclick="consultarGruposDeTecnoparque_Proyecto_FaseInicio_table();">
                            Agregar
                        </a>
                    </div>
                @endif
            @else
            <div class="row center">
                <a class="btn btn-medium teal" onclick="consultarGruposDeTecnoparque_Proyecto_FaseInicio_table();">
                    Agregar
                </a>
            </div>
            @endif
            <table id="propiedadIntelectual_Grupos">
                <thead>
                    <tr>
                        <th style="width: 80%">Código y Nombre del Grupo de Investigación</th>
                        @if ($existe)
                            @if ($proyecto->present()->proyectoFase() == 'Inicio')
                            <th style="width: 20%">Eliminar</th>
                            @endif
                        @else
                        <th style="width: 20%">Eliminar</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if ($existe)
                        @foreach ($proyecto->gruposinvestigacion as $key => $value)
                            <tr id="propietarioAsociadoAlProyecto_Grupo{{$value->id}}">
                            <td><input type="hidden" name="propietarios_grupos[]" value="{{$value->id}}">{{$value->codigo_grupo}} - {{ $value->entidad->nombre }}</td>
                            @if ($proyecto->present()->proyectoFase() == 'Inicio')
                            <td><a class="waves-effect bg-danger white-text btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Grupo({{$value->id}});"><i class="material-icons">delete_sweep</i></a></td>
                            @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row center">
    <small id="propietarios_user-error" class="error red-text"></small>
    <small id="propietarios_empresas-error" class="error red-text"></small>
    <small id="propietarios_grupos-error" class="error red-text"></small>
</div>
<div class="divider"></div>
<center>
    @if ($existe)
        @can('showUpdateButton', [$proyecto, 'Inicio'])
        <button type="submit" class="waves-effect waves-light btn bg-secondary center-align">
            <i class="material-icons right">{{ isset($btnText) ? $btnText == 'Guardar' ? 'send' : 'send' : '' }}</i>
            {{isset($btnText) ? $btnText : 'error'}}
        </button>
        @endcan
    @else
        <button type="submit" class="waves-effect waves-light btn bg-secondary center-align">
            <i class="material-icons right">{{ isset($btnText) ? $btnText == 'Guardar' ? 'send' : 'send' : '' }}</i>
            {{isset($btnText) ? $btnText : 'error'}}
        </button>
    @endif
    <a href="{{ $existe ? route('proyecto.inicio', $proyecto->id) : route('proyecto') }}" class="waves-effect bg-danger btn center-align">
        <i class="material-icons left">backspace</i>Cancelar
    </a>
</center>
