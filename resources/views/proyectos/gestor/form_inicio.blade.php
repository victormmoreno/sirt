<form id="frmProyectosCreate" action="{{route('proyecto.store')}}" method="POST">
    {!! csrf_field() !!}
    <div class="row">
        <div class="input-field col s12 m6 l6">
            <input disabled id="txtgestor" name="txtgestor" value="{{ auth()->user()->nombres }} {{ auth()->user()->apellidos }}" type="text">
            <label for="txtgestor" class="">Gestor</label>
        </div>
        <div class="input-field col s12 m6 l6">
            <input disabled id="txtlinea" name="txtlinea" value="{{ auth()->user()->gestor->lineatecnologica->nombre }}" type="text">
            <label for="txtlinea" class="">Línea Tecnológica</label>
        </div>
    </div>
    <div class="divider"></div>
    <div class="row">
        <h5 class="center"><i class="material-icons">lightbulb</i>Idea de Proyecto.</h5>
    </div>
    <div class="row">
        <div class="col s12 m6 l6 offset-l3 m3">
            <center>
                <div class="card-panel grey lighten-3">
                    <div class="row">
                        <div class="input-field col s12 m12 l12">
                            <input type="text" id="txtnombreIdeaProyecto_Proyecto" name="txtnombreIdeaProyecto_Proyecto" readonly>
                            <label for="txtnombreIdeaProyecto_Proyecto">Idea de Proyecto</label>
                            <small id="txtidea_id-error" class="error red-text"></small>
                        </div>
                        <a class="btn-floating blue" onclick="consultarIdeasDeProyectoEmprendedores_Proyecto_FaseInicio();"><i class="material-icons left">search</i>Buscar</a>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12 l12">
                            <input type="text" id="txtnombre" name="txtnombre">
                            <label for="txtnombre">Nombre de Proyecto <span class="red-text">*</span></label>
                            <small id="txtnombre-error" class="error red-text"></small>
                        </div>
                    </div>
                </div>
            </center>
            <input type="hidden" name="txtidea_id" id="txtidea_id" value="">
        </div>
    </div>
    <div class="divider"></div>
    <div class="row">
        <h5 class="center">Datos del proyecto.</h5>
    </div>
    <div class="row">
        <div class="input-field col s12 m6 l6">
            <select style="width: 100%" class="js-states" id="txtareaconocimiento_id" name="txtareaconocimiento_id" onchange="selectAreaConocimiento_Proyecto_FaseInicio();">
                <option value="">Seleccione el área de conocimiento</option>
                @forelse ($areasconocimiento as $id => $value)
                <option value="{{$id}}">{{$value}}</option>
                @empty
                <option value=""> No hay información disponible</option>
                @endforelse
            </select>
            <label for="txtareaconocimiento_id">Áreas de Conocmiento <span class="red-text">*</span></label>
            <small id="txtareaconocimiento_id-error" class="error red-text"></small>
        </div>
        <div class="input-field col s12 m6 l6">
            <select id="txtsublinea_id" class="js-states" name="txtsublinea_id" style="width: 100%">
                <option value="">Seleccione la Sublínea</option>
                @forelse ($sublineas as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
                @empty
                <option value="">No hay información disponible</option>
                @endforelse
            </select>
            <label for="txtsublinea_id">Sublínea <span class="red-text">*</span></label>
            <small id="txtsublinea_id-error" class="error red-text"></small>
        </div>
    </div>
    <div class="row" id="otroAreaConocimiento_content">
        <div class="input-field col s12 m12 l12">
            <input type="text" id="txtotroareaconomiento" name="txtotroareaconomiento">
            <label for="txtotroareaconomiento">Otro área de conocimiento. <span class="red-text">*</span></label>
            <small id="txtotroareaconomiento-error" class="error red-text"></small>
        </div>
    </div>
    <div class="row">
        <div class="col s6 m6 l6">
            <span class="black-text text-black">TRL que se pretende realizar <span class="red-text">*</span></span>
            <div class="switch m-b-md">
                <label>
                    TRL 6
                    <input type="checkbox" name="posible_trl" id="posible_trl" value="1">
                    <span class="lever"></span>
                    TRL 7 - TRL 8
                </label>
            </div>
        </div>
        <!-- <div class="col s12 m6 l6">
            <p class="card-title">TRL que se pretende realizar <span class="red-text">*</span></p><br>
            <div class="input-field col s12 m12 l12">
                <p class="p-v-xs">
                    <input class="with-gap" name="posible_trl" type="radio" id="TRL6" value="0" />
                    <label for="TRL6">TRL 6</label>
                    <input class="with-gap" name="posible_trl" type="radio" id="TRL7_8" value="1" />
                    <label for="TRL7_8">TRL 7 - TRL 8</label>
                </p>
                <small id="posible_trl-error" class="center-align error red-text"></small>
            </div>
        </div> -->
        <div class="col s6 m6 l6">
            <span class="black-text text-black">¿Recibido a través del área de emprendimiento SENA? <span class="red-text">*</span></span>
            <div class="switch m-b-md">
                <label>
                    No
                    <input type="checkbox" name="txtreci_ar_emp" id="txtreci_ar_emp" value="1">
                    <span class="lever"></span>
                    Si
                </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m4 l4">
            <div class="row">
                <span class="black-text text-black">¿El proyecto pertenece a la economía naranja? <span class="red-text">*</span></span>
                <div class="switch m-b-md">
                    <label>
                        No
                        <input type="checkbox" name="txteconomia_naranja" id="txteconomia_naranja" value="1" onchange="showInput_EconomiaNaranja()">
                        <span class="lever"></span>
                        Si
                    </label>
                </div>
            </div>
            <div class="row" id="economiaNaranja_content">
                <div class="input-field col s12 m12 l12">
                    <input type="text" id="txttipoeconomia_naranja" name="txttipoeconomia_naranja">
                    <label for="txttipoeconomia_naranja">Tipo de Proyecto de Economía Naranja. <span class="red-text">*</span></label>
                    <small id="txttipoeconomia_naranja-error" class="error red-text"></small>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l4">
            <div class="row">
                <span class="black-text text-black">¿El proyecto está dirigido a discapacitados? <span class="red-text">*</span></span>
                <div class="switch m-b-md">
                    <label>
                        No
                        <input type="checkbox" name="txtdirigido_discapacitados" id="txtdirigido_discapacitados" value="1" onchange="showInput_Discapacidad()">
                        <span class="lever"></span>
                        Si
                    </label>
                </div>
            </div>
            <div class="row" id="discapacidad_content">
                <div class="input-field col s12 m12 l12">
                    <input type="text" id="txttipo_discapacitados" name="txttipo_discapacitados">
                    <label for="txttipo_discapacitados">Tipo de Discapacitados. <span class="red-text">*</span></label>
                    <small id="txttipo_discapacitados-error" class="error red-text"></small>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l4">
            <div class="row">
                <span class="black-text text-black">Articulado con CT+i <span class="red-text">*</span></span>
                <div class="switch m-b-md">
                    <label>
                        No
                        <input type="checkbox" name="txtarti_cti" id="txtarti_cti" value="1" onchange="showInput_ActorCTi()">
                        <span class="lever"></span>
                        Si
                    </label>
                </div>
            </div>
            <div class="row" id="nombreActorCTi_content">
                <div class="input-field col s12 m12 l12">
                    <input type="text" name="txtnom_act_cti" id="txtnom_act_cti">
                    <label for="txtnom_act_cti">Nombre del Actor CT+i <span class="red-text">*</span></label>
                    <small id="txtnom_act_cti-error" class="error red-text"></small>
                </div>
            </div>
        </div>
    </div>
    <div class="divider"></div>
    <div class="row">
        <h5 class="center"><i class="material-icons">supervised_user_circle</i>Talentos que participarán en el proyecto</h5>
    </div>
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card-content">
                <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header active blue-grey lighten-1"><i class="material-icons">people</i>Pulse aquí para ver la información de los talentos.</div>
                        <div class="collapsible-body">
                            <div class="card-content">
                                <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                                    <li>
                                        <div class="collapsible-header cyan lighten-1"><i class="material-icons">group_add</i>Pulse aquí para ver los talentos y asociarlos al proyecto.</div>
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
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                                    <li>
                                        <div class="collapsible-header active green lighten-1"><i class="material-icons">how_to_reg</i>Pulse aquí para la información de los talentos asociados al proyecto.</div>
                                        <div class="collapsible-body">
                                            {{-- Collapsible 2 --}}
                                            <div class="card-content">
                                                <div class="row">
                                                    <table id="detalleTalentosDeUnProyecto_Create" class="striped">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 15%">Talento Interlocutor</th>
                                                                <th style="width: 40%">Talento</th>
                                                                <th style="width: 20%">Eliminar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

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
    <div class="divider"></div>
    <div class="row">
        <h5 class="center">Objetivos y alcance del proyecto.</h5>
    </div>
    <div class="row">
        <div class="col s12 m6 l6">
            <div class="input-field col s12 m12 l12">
                <textarea name="txtobjetivo" class="materialize-textarea" length="500" maxlength="500" id="txtobjetivo"></textarea>
                <label for="txtobjetivo">Objetivo General del Proyecto</label>
                <small id="txtobjetivo-error" class="error red-text"></small>
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="input-field col s12 m12 l12">
                <textarea name="txtalcance_proyecto" class="materialize-textarea" length="1000" maxlength="1000" id="txtalcance_proyecto"></textarea>
                <label for="txtalcance_proyecto">Alcance del proyecto</label>
                <small id="txtalcance_proyecto-error" class="error red-text"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="input-field col s12 m12 l12">
                <input type="text" id="txtobjetivo_especifico1" name="txtobjetivo_especifico1">
                <label for="txtobjetivo_especifico1">Objetivo Específico <span class="red-text">*</span></label>
                <small id="txtobjetivo_especifico1-error" class="error red-text"></small>
            </div>
            <div class="input-field col s12 m12 l12">
                <input type="text" id="txtobjetivo_especifico2" name="txtobjetivo_especifico2">
                <label for="txtobjetivo_especifico2">Objetivo Específico <span class="red-text">*</span></label>
                <small id="txtobjetivo_especifico2-error" class="error red-text"></small>
            </div>
            <div class="input-field col s12 m12 l12">
                <input type="text" id="txtobjetivo_especifico3" name="txtobjetivo_especifico3">
                <label for="txtobjetivo_especifico3">Objetivo Específico <span class="red-text">*</span></label>
                <small id="txtobjetivo_especifico3-error" class="error red-text"></small>
            </div>
            <div class="input-field col s12 m12 l12">
                <input type="text" id="txtobjetivo_especifico4" name="txtobjetivo_especifico4">
                <label for="txtobjetivo_especifico4">Objetivo Específico <span class="red-text">*</span></label>
                <small id="txtobjetivo_especifico4-error" class="error red-text"></small>
            </div>
        </div>
    </div>
    <div class="divider"></div>
    <div class="row">
        <h5 class="center">Datos de la propiedad intelectual.</h5>
    </div>
    <div class="row">
        <div class="input-field col s12 m4 l4">
            <select style="width: 100%" class="js-states" id="txttipo_entidad" name="txttipo_entidad" onchange="setPropiedadIntelectual_Proyecto_FaseInicio()">
                <option value="-1">Seleccione un tipo de dueño de la propiedad intelectual.</option>
                <option value="0">Persona</option>
                <option value="1">Grupo de Investigación</option>
                <option value="2">Empresa</option>
            </select>
            <label for="txttipo_entidad">Tipos de dueños de la propiedad intelectual <span class="red-text">*</span></label>
            <small id="txttipo_entidad-error" class="error red-text"></small>
        </div>
    </div>
    <div class="row" id="datosPersona_PropiedadIntelectual_Proyecto_FaseInicio">
        <div class="input-field col s12 m4 l4">
            <input type="text" id="txtdocumento_persona_propiedadIntelectual" name="txtdocumento_persona_propiedadIntelectual">
            <label for="txtdocumento_persona_propiedadIntelectual">Número de Documento <span class="red-text">*</span></label>
        </div>
        <div class="input-field col s12 m6 l6">
            <input type="text" id="txtnombres_persona_propiedadIntelectual" name="txtnombres_persona_propiedadIntelectual">
            <label for="txtnombres_persona_propiedadIntelectual">Nombres y apellidos completos <span class="red-text">*</span></label>
        </div>
        <div clas="col s12 m2 l2">
        <a class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
        </div>
    </div>
    <div class="row" id="datosEmpresa_PropiedadIntelectual_Proyecto_FaseInicio">

    </div>
    <div class="row" id="datosGrupo_PropiedadIntelectual_Proyecto_FaseInicio">

    </div>
    <div class="row">
        <div class="col s12 m4 l4">
            <div class="card red">
                <table id="propiedadIntelectual_Personas" class="striped">
                    <thead>
                        <tr>
                            <th style="width: 15%">Número de Documento</th>
                            <th style="width: 40%">Nombre Completo</th>
                            <th style="width: 20%">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
    
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col s12 m4 l4">
            <div class="card blue">
                <table id="propiedadIntelectual_Empresas" class="striped">
                    <thead>
                        <tr>
                            <th style="width: 15%">Nit</th>
                            <th style="width: 40%">Nombre de la Empresa</th>
                            <th style="width: 20%">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
    
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col s12 m4 l4">
            <div class="card yellow">
                <table id="propiedadIntelectual_Grupos" class="striped">
                    <thead>
                        <tr>
                            <th style="width: 15%">Código del Grupo</th>
                            <th style="width: 40%">Nombre del Grupo de Investigación</th>
                            <th style="width: 20%">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>