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
        <h5 class="center"><i class="material-icons">lightbulb</i>Idea de Proyecto</h5>
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
        <h5 class="center">Datos del Proyecto</h5>
    </div>
    <div class="row">
        <div class="col s12 m6 l6">
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
        </div>
        <div class="col s12 m6 l6">
            <div class="input-field col s12 m12 l12">
                <textarea name="txtalcance_proyecto" class="materialize-textarea" length="500" maxlength="500" id="txtalcance_proyecto"></textarea>
                <label for="txtalcance_proyecto">Alcance del proyecto</label>
                <small id="txtalcance_proyecto-error" class="error red-text"></small>
            </div>
        </div>
    </div>
    <div class="divider"></div>
    <div class="row">
        <h5 class="center">Objetivos</h5>
    </div>
    <div class="row">
        <div class="col s12 m6 l6">
            <div class="input-field col s12 m12 l12 valign-wrapper">
                <textarea name="txtobjetivo_general" class="materialize-textarea" length="500" maxlength="500" id="txtobjetivo_general" style="height: 200px"></textarea>
                <label for="txtobjetivo_general">Objetivo General del Proyecto</label>
                <small id="txtobjetivo_general-error" class="error red-text"></small>
            </div>
        </div>
        <div class="col s12 m6 l6">
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
</form>