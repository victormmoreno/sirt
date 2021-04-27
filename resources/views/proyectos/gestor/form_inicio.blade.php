{!! csrf_field() !!}
@php
    $existe = isset($proyecto) ? true : false;
@endphp
<div class="row">
    <div class="input-field col s12 m6 l6">
        <input disabled id="txtgestor" name="txtgestor"
            value="{{ auth()->user()->nombres }} {{ auth()->user()->apellidos }}" type="text">
        <label for="txtgestor" class="">Gestor</label>
    </div>
    <div class="input-field col s12 m6 l6">
        <input disabled id="txtlinea" name="txtlinea" value="{{ auth()->user()->gestor->lineatecnologica->nombre }}"
            type="text">
        <label for="txtlinea" class="">Línea Tecnológica</label>
    </div>
</div>

<div class="row">
    <h5 class="center orange-text"><i class="material-icons">lightbulb</i>Idea de Proyecto.</h5>
</div>
<div class="divider"></div>
<div class="row">
    <div class="col s12 m6 l6 offset-l3 m3">
        <center>
            <div class="card-panel grey lighten-3">
                <div class="row">
                    <div class="input-field col s12 m12 l12">
                        <input type="text" id="txtnombreIdeaProyecto_Proyecto" name="txtnombreIdeaProyecto_Proyecto" value="{{ $btnText == 'Guardar' ? '' : $proyecto->idea->codigo_idea . ' - ' . $proyecto->idea->nombre_proyecto }}" readonly>
                        <label for="txtnombreIdeaProyecto_Proyecto">Idea de Proyecto</label>
                        <small id="txtidea_id-error" class="error red-text"></small>
                    </div>
                    @if ($btnText == 'Guardar')
                    <a class="btn-floating blue" onclick="consultarIdeasDeProyectoEmprendedores_Proyecto_FaseInicio();">
                        <i class="material-icons left">search</i>Buscar
                    </a>
                    @endif
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l12">
                        @if ($existe)
                        <input type="text" {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} id="txtnombre" name="txtnombre" value="{{ $proyecto->articulacion_proyecto->actividad->nombre }}">
                        @else
                        <input type="text" id="txtnombre" name="txtnombre" value="">
                        @endif
                        <label for="txtnombre">Nombre de Proyecto <span class="red-text">*</span></label>
                        <small id="txtnombre-error" class="error red-text"></small>
                    </div>
                </div>
            </div>
        </center>
        @if ($existe)
        <input type="hidden" name="txtidea_id" id="txtidea_id" value="{{ $proyecto->idea->id }}">
        @else
        <input type="hidden" name="txtidea_id" id="txtidea_id" value="">
        @endif
    </div>
</div>

<div class="row">
    <h5 class="center orange-text">Datos del proyecto.</h5>
</div>
<div class="divider"></div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        @if ($existe)
        <select {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} style="width: 100%" class="js-states" id="txtareaconocimiento_id" name="txtareaconocimiento_id"
            onchange="selectAreaConocimiento_Proyecto_FaseInicio();">
            <option value="">Seleccione el área de conocimiento</option>
            @forelse ($areasconocimiento as $id => $value)
            <option value="{{$id}}" {{ !isset($proyecto) ? '' : $proyecto->areaconocimiento_id == $id ? 'selected' : '' }}>{{$value}}</option>
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
        <select {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} id="txtsublinea_id" class="js-states" name="txtsublinea_id" style="width: 100%">
            <option value="">Seleccione la Sublínea</option>
            @forelse ($sublineas as $key => $value)
            <option value="{{$key}}" {{ $btnText == 'Guardar' ? '' : $proyecto->sublinea_id == $key ? 'selected' : '' }}>{{$value}}</option>
            @empty
            <option value="">No hay información disponible</option>
            @endforelse
        </select>
        @else
        <select id="txtsublinea_id" class="js-states" name="txtsublinea_id" style="width: 100%">
            <option value="">Seleccione la Sublínea</option>
            @forelse ($sublineas as $key => $value)
            <option value="{{$key}}">{{$value}}</option>
            @empty
            <option value="">No hay información disponible</option>
            @endforelse
        </select>
        @endif
        <label for="txtsublinea_id">Sublínea <span class="red-text">*</span></label>
        <small id="txtsublinea_id-error" class="error red-text"></small>
    </div>
</div>
<div class="row" id="otroAreaConocimiento_content">
    <div class="input-field col s12 m12 l12">
        @if ($existe)
        <input {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} type="text" id="txtotro_areaconocimiento" name="txtotro_areaconocimiento" value="{{ $btnText == 'Guardar' ? '' : $proyecto->otro_areaconocimiento }}">
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
                <input {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} type="checkbox" name="trl_esperado" id="trl_esperado" value="1" {{ $btnText == 'Guardar' ? '' : ($proyecto->trl_esperado == 0 ? '' : 'checked') }}>
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
                <input {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} type="checkbox" name="txtfabrica_productividad" id="txtfabrica_productividad" value="1" {{ $btnText == 'Guardar' ? '' : ($proyecto->fabrica_productividad == 0 ? '' : 'checked') }}>
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
                <input {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} type="checkbox" name="txtreci_ar_emp" id="txtreci_ar_emp" value="1" {{ $btnText == 'Guardar' ? '' : ($proyecto->reci_ar_emp == 0 ? '' : 'checked') }}>
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
                    <input {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} type="checkbox" name="txteconomia_naranja" id="txteconomia_naranja" value="1" {{ $btnText == 'Guardar' ? '' : ($proyecto->economia_naranja == 0 ? '' : 'checked') }} onchange="showInput_EconomiaNaranja()">
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
                <input {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} type="text" id="txttipo_economianaranja" name="txttipo_economianaranja" value="{{ $btnText == 'Guardar' ? '' : $proyecto->tipo_economianaranja }}">
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
                    <input {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} type="checkbox" name="txtdirigido_discapacitados" id="txtdirigido_discapacitados" value="1" {{ $btnText == 'Guardar' ? '' : ($proyecto->dirigido_discapacitados == 0 ? '' : 'checked') }} onchange="showInput_Discapacidad()">
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
                <input {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} type="text" id="txttipo_discapacitados" name="txttipo_discapacitados" value="{{ $btnText == 'Guardar' ? '' : $proyecto->tipo_discapacitados }}">
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
                    <input {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} type="checkbox" name="txtarti_cti" id="txtarti_cti" value="1" {{ $btnText == 'Guardar' ? '' : ($proyecto->art_cti == 0 ? '' : 'checked') }} onchange="showInput_ActorCTi()">
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
                <input {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} type="text" name="txtnom_act_cti" id="txtnom_act_cti" value="{{ $btnText == 'Guardar' ? '' : $proyecto->nom_act_cti }}">
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
    <h5 class="center orange-text"><i class="material-icons">supervised_user_circle</i>Talentos que participarán en el proyecto</h5>
</div>
<div class="divider"></div>
<div class="row">
    <div class="col s12 m12 l12">
        <div class="card-content">
            <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header active blue-grey lighten-1"><i class="material-icons">people</i>
                        Pulse aquí para ver la información de los talentos.
                    </div>
                    <div class="collapsible-body">
                        <div class="card-content">
                            @if ($existe)
                                @if ($proyecto->fase->nombre == 'Inicio')
                                <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                                    <li>
                                        <div class="collapsible-header cyan lighten-1"><i class="material-icons">group_add</i>
                                            Pulse aquí para ver los talentos y asociarlos al proyecto.</div>
                                        <div class="collapsible-body">
                                            {{-- Collapsible 1 --}}
                                            <div class="card-content">
                                                <div class="row">
                                                    <table id="talentosDeTecnoparque_Proyecto_FaseInicio_table" style="width: 100%">
                                                        <thead>
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
                            @else
                            <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                                <li>
                                    <div class="collapsible-header cyan lighten-1"><i class="material-icons">group_add</i>
                                        Pulse aquí para ver los talentos y asociarlos al proyecto.</div>
                                    <div class="collapsible-body">
                                        {{-- Collapsible 1 --}}
                                        <div class="card-content">
                                            <div class="row">
                                                <table id="talentosDeTecnoparque_Proyecto_FaseInicio_table" style="width: 100%">
                                                    <thead>
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
                                    <div class="collapsible-header active green lighten-1"><i class="material-icons">how_to_reg</i>
                                        Pulse aquí para la información de los talentos asociados al proyecto.
                                    </div>
                                    <div class="collapsible-body">
                                        {{-- Collapsible 2 --}}
                                        <div class="card-content">
                                            <div class="row">
                                                <table id="detalleTalentosDeUnProyecto_Create" class="striped">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 15%">Talento Interlocutor</th>
                                                            <th style="width: 40%">Talento</th>
                                                            @if ($existe)
                                                                @if ($proyecto->fase->nombre == 'Inicio')
                                                                <th style="width: 20%">Eliminar</th>
                                                                @endif
                                                            @else
                                                                <th style="width: 20%">Eliminar</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($existe)
                                                            @foreach ($proyecto->articulacion_proyecto->talentos as $key => $value)
                                                                <tr id="talentoAsociadoAProyecto{{$value->id}}">
                                                                <td><input type="radio" {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} class="with-gap" {{$value->pivot->talento_lider == 1 ? 'checked' : ''}} name="radioTalentoLider" id="radioButton'{{$value->id}}'" value="{{$value->id}}"/><label for ="radioButton'{{$value->id}}'"></label></td>
                                                                <td><input type="hidden" name="talentos[]" value="{{$value->id}}">{{$value->user()->withTrashed()->first()->documento}} - {{$value->user()->withTrashed()->first()->nombres}} {{$value->user()->withTrashed()->first()->apellidos}}</td>
                                                                @if ($proyecto->fase->nombre == 'Inicio')
                                                                <td><a class="waves-effect red lighten-3 btn" onclick="eliminarTalentoDeProyecto_FaseInicio({{$value->id}});"><i class="material-icons">delete_sweep</i></a></td>
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
<h5 class="center orange-text">Objetivos y alcance del proyecto.</h5>
<div class="divider"></div>
<div class="row">
    <div class="col s12 m6 l6">
        <div class="input-field col s12 m12 l12">
            @if ($existe)
            <textarea {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} name="txtobjetivo" class="materialize-textarea" length="500" maxlength="500" id="txtobjetivo">{{ $btnText == 'Guardar' ? '' : $proyecto->articulacion_proyecto->actividad->objetivo_general }}</textarea>
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
            <textarea {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} name="txtalcance_proyecto" class="materialize-textarea" length="1000" maxlength="1000" id="txtalcance_proyecto">{{ $btnText == 'Guardar' ? '' : $proyecto->alcance_proyecto }}</textarea>
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
            <input {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} type="text" id="txtobjetivo_especifico1" name="txtobjetivo_especifico1" value="{{ $btnText == 'Guardar' ? '' : $proyecto->articulacion_proyecto->actividad->objetivos_especificos[0]->objetivo }}">
            @else
            <input type="text" id="txtobjetivo_especifico1" name="txtobjetivo_especifico1" value="">
            @endif
            <label for="txtobjetivo_especifico1">Primer Objetivo Específico <span class="red-text">*</span></label>
            <small id="txtobjetivo_especifico1-error" class="error red-text"></small>
        </div>
        <div class="input-field col s12 m12 l12">
            @if ($existe)
            <input {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} type="text" id="txtobjetivo_especifico2" name="txtobjetivo_especifico2" value="{{ $btnText == 'Guardar' ? '' : $proyecto->articulacion_proyecto->actividad->objetivos_especificos[1]->objetivo }}">
            @else
            <input type="text" id="txtobjetivo_especifico2" name="txtobjetivo_especifico2" value="">
            @endif
            <label for="txtobjetivo_especifico2">Segundo Objetivo Específico <span class="red-text">*</span></label>
            <small id="txtobjetivo_especifico2-error" class="error red-text"></small>
        </div>
        <div class="input-field col s12 m12 l12">
            @if ($existe)
            <input {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} type="text" id="txtobjetivo_especifico3" name="txtobjetivo_especifico3" value="{{ $btnText == 'Guardar' ? '' : $proyecto->articulacion_proyecto->actividad->objetivos_especificos[2]->objetivo }}">
            @else
            <input type="text" id="txtobjetivo_especifico3" name="txtobjetivo_especifico3" value="">
            @endif
            <label for="txtobjetivo_especifico3">Tercer Objetivo Específico <span class="red-text">*</span></label>
            <small id="txtobjetivo_especifico3-error" class="error red-text"></small>
        </div>
        <div class="input-field col s12 m12 l12">
            @if ($existe)
            <input {{$proyecto->fase->nombre != 'Inicio' ? 'disabled' : '' }} type="text" id="txtobjetivo_especifico4" name="txtobjetivo_especifico4" value="{{ $btnText == 'Guardar' ? '' : $proyecto->articulacion_proyecto->actividad->objetivos_especificos[3]->objetivo }}">
            @else
            <input type="text" id="txtobjetivo_especifico4" name="txtobjetivo_especifico4" value="">
            @endif
            <label for="txtobjetivo_especifico4">Cuarto Objetivo Específico <span class="red-text">*</span></label>
            <small id="txtobjetivo_especifico4-error" class="error red-text"></small>
        </div>
    </div>
</div>
<h5 class="center orange-text">Datos de la propiedad intelectual.</h5>
<div class="divider"></div>
<div class="row">
    <div class="col s12 m4 l4">
        <div class="card-panel green lighten-5">
            <div class="row">
                <h5 class="center">Talentos dueños de la propiedad intelectual.</h5>
            </div>
            @if ($existe)
                @if ($proyecto->fase->nombre == 'Inicio')
                    <div class="row center">
                        <a class="btn btn-medium green" onclick="consultarTalentosDeTecnoparque_Proyecto_FaseInicio_table('#posiblesPropietarios_Personas_table', 'add_propiedad');">
                            Agregar
                        </a>
                    </div>
                @endif
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
                            @if ($proyecto->fase->nombre == 'Inicio')
                            <th style="width: 20%">Eliminar</th>
                            @endif
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
                            @if ($proyecto->fase->nombre == 'Inicio')
                            <td><a class="waves-effect red lighten-3 btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Persona({{$value->id}});"><i class="material-icons">delete_sweep</i></a></td>
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
                @if ($proyecto->fase->nombre == 'Inicio')
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
                            @if ($proyecto->fase->nombre == 'Inicio')
                            <th style="width: 20%">Eliminar</th>
                            @endif
                        @else
                            <th style="width: 20%">Eliminar</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if ($existe)
                        @foreach ($proyecto->empresas as $key => $value)
                            <tr id="propietarioAsociadoAlProyecto_Empresa{{$value->id}}">
                            <td><input type="hidden" name="propietarios_empresas[]" value="{{$value->id}}">{{$value->nit}} - {{ $value->entidad->nombre }}</td>
                            @if ($proyecto->fase->nombre == 'Inicio')
                            <td><a class="waves-effect red lighten-3 btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Empresa({{$value->id}});"><i class="material-icons">delete_sweep</i></a></td>
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
                @if ($proyecto->fase->nombre == 'Inicio')
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
                            @if ($proyecto->fase->nombre == 'Inicio')
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
                            @if ($proyecto->fase->nombre == 'Inicio')
                            <td><a class="waves-effect red lighten-3 btn" onclick="eliminarPropietarioDeUnProyecto_FaseInicio_Grupo({{$value->id}});"><i class="material-icons">delete_sweep</i></a></td>
                            @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <!-- <small id="propietarios_entidad-error" class="error red-text"></small> -->
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
        @if ($proyecto->fase->nombre == 'Inicio')
        <button type="submit" class="waves-effect cyan darken-1 btn center-aling">
            <i class="material-icons right">{{ isset($btnText) ? $btnText == 'Modificar' ? 'done' : 'done_all' : '' }}</i>
            {{isset($btnText) ? $btnText : 'error'}}
        </button>
        @endif
    @else
    <button type="submit" class="waves-effect cyan darken-1 btn center-aling">
        <i class="material-icons right">{{ isset($btnText) ? $btnText == 'Modificar' ? 'done' : 'done_all' : '' }}</i>
        {{isset($btnText) ? $btnText : 'error'}}
    </button>   
    @endif
    <a href="{{route('proyecto')}}" class="waves-effect red lighten-2 btn center-aling">
        <i class="material-icons right">backspace</i>Cancelar
    </a>
</center>