@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5>
            <a class="footer-text left-align" href="{{route('proyecto')}}">
              <i class="material-icons arrow-l">arrow_back</i>
            </a> Proyectos
          </h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <br>
                <center>
                  <span class="card-title center-align"><b>Modificar Proyecto - {{ $proyecto->codigo_proyecto }}</b></span>
                </center>
                <div class="divider"></div>
                <div class="card-panel red lighten-3">
                  <div class="card-content white-text">
                    <a class="btn-floating red"><i class="material-icons left">info_outline</i></a>
                    <span>Los elementos con (*) son obligatorios</span>
                  </div>
                </div>
                <br />
                <form id="frmProyectosCreate" action="{{route('proyecto.update', $proyecto->id)}}" method="POST">
                  {!! method_field('PUT')!!}
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
                  <div class="row">
                    <div class="input-field col s12 m12 l12">
                      <select class="js-states" id="txttipoarticulacionproyecto_id" name="txttipoarticulacionproyecto_id" onchange="consultarEntidadesSegunElCaso(this.value);">
                        <option value="">Seleccione el Tipo de Articulación</option>
                        @forelse ($tipoarticulacion as $id => $value)
                          <option value="{{$id}}" {{ $proyecto->tipoarticulacionproyecto_id == $id ? 'selected': '' }}>{{$value}}</option>
                        @empty
                          <option value="">No hay información disponible</option>
                        @endforelse
                      </select>
                      <label for="txttipoarticulacionproyecto_id">Tipo de Proyecto <span class="red-text">*</span></label>
                      <small id="txttipoarticulacionproyecto_id-error" class="error red-text"></small>
                    </div>
                  </div>
                  <div class="row" id="divOtroTipoArticulacion" >
                    <div class="input-field col s12 m12 l12">
                      <input type="text" name="txtotro_tipoarticulacion" id="txtotro_tipoarticulacion" value="{{ $proyecto->otro_tipoarticulacion }}">
                      <label for="txtotro_tipoarticulacion">¿Cuál? <span class="red-text">*</span></label>
                      <small id="txtotro_tipoarticulacion-error" class="error red-text"></small>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <select id="txtsublinea_id" class="js-states" name="txtsublinea_id" style="width: 100%">
                        <option value="">Seleccione la Sublínea</option>
                        @forelse ($sublineas as $id => $value)
                          <option value="{{$id}}" {{ $proyecto->sublinea_id == $id ? 'selected': '' }}>{{$value}}</option>
                        @empty
                          <option value="">No hay información disponible</option>
                        @endforelse
                      </select>
                      <label for="txtsublinea_id">Sublínea <span class="red-text">*</span></label>
                      <small id="txtsublinea_id-error" class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <select id="txtsector_id" class="js-states" name="txtsector_id" style="width: 100%;">
                        <option value="">Seleccione el Sector</option>
                        @forelse ($sectores as $id => $value)
                          <option value="{{$id}}" {{ $proyecto->sector_id == $id ? 'selected' : '' }}>{{$value}}</option>
                        @empty
                          <option value="">No hay información disponible</option>
                        @endforelse
                      </select>
                      <label for="txtsector_id">Sector <span class="red-text">*</span></label>
                      <small id="txtsector_id-error" class="error red-text"></small>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <select style="width: 100%" class="js-states" id="txtareaconocimiento_id" name="txtareaconocimiento_id">
                        <option value="">Seleccione el área de conocimiento</option>
                        @forelse ($areasconocimiento as $id => $value)
                          <option value="{{$id}}" {{ $proyecto->areaconocimiento_id == $id ? 'selected' : '' }}>{{$value}}</option>
                        @empty
                          <option value=""> No hay información disponible</option>
                        @endforelse
                      </select>
                      <label for="txtareaconocimiento_id">Área de Conocmiento <span class="red-text">*</span></label>
                      <small id="txtareaconocimiento_id-error" class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <select id="txtestadoproyecto_id" name="txtestadoproyecto_id" style="width: 100%;" onchange="setFechaCierreProyecto()">
                        <option value="">Seleccione el Estado del Proyecto</option>
                        @forelse ($estadosproyecto as $id => $value)
                          <option value="{{$id}}" {{ $proyecto->estadoproyecto_id == $id ? 'selected' : '' }}>{{$value}}</option>
                        @empty
                          <option value="">No hay información disponible.</option>
                        @endforelse
                      </select>
                      <label for="txtestadoproyecto_id">Estado del Proyecto <span class="red-text">*</span></label>
                      <small id="txtestadoproyecto_id-error" class="error red-text"></small>
                      <!-- <label>Estado del Proyecto *</label> -->
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12 m6 l6 offset-l3 m3">
                      <input type="text" name="txtfecha_inicio" id="txtfecha_inicio" value="{{ $proyecto->fecha_inicio }}" class="datepicker picker__input">
                      <label for="txtfecha_inicio">Fecha de Inicio <span class="red-text">*</span></label>
                      <small id="txtfecha_inicio-error" class="error red-text"></small>
                    </div>
                  </div>
                  <div class="row">
                    <div id="divFechaCierreProyecto">
                      <div class="card indigo lighten-5 col s12 m8 l8">
                        <div class="card-content">
                          <div class="input-field col s12 m6 l6">
                            <input type="text" name="txtfecha_fin" id="txtfecha_fin" value="" class="datepicker picker__input">
                            <label for="txtfecha_fin">Fecha de Cierre <span class="red-text">*</span></label>
                            <small id="txtfecha_fin-error" class="error red-text"></small>
                          </div>
                          <div class="input-field col s12 m6 l6">
                            <select id="txtestadoprototipo_id" name="txtestadoprototipo_id" style="width: 100%;" onchange="setOtroEstadoPrototipo(this.value);">
                              <option value="">Seleccione el Estado del Prototipo</option>
                              @forelse ($estadosprototipos as $id => $value)
                                <option value="{{$id}}" {{ $proyecto->estadoprototipo_id == $id ? 'selected' : '' }}>{{$value}}</option>
                              @empty
                                <option value="">No hay información disponible.</option>
                              @endforelse
                            </select>
                            <label for="txtestadoprototipo_id">Estado del Prototipo <span class="red-text">*</span></label>
                            <small id="txtestadoprototipo_id-error" class="error red-text"></small>
                          </div>
                        </div>
                      </div>
                      <div id="divOtroEstadoPrototipo">
                        <div class="card blue lighten-5 col s12 m4 l4">
                          <div class="card-content">
                            <div class="input-field col s12 m12 l12">
                              <input type="text" name="txtotro_estadoprototipo" id="txtotro_estadoprototipo" value="">
                              <label for="txtotro_estadoprototipo">¿Cuál? <span class="red-text">*</span></label>
                              <small id="txtotro_estadoprototipo-error" class="error red-text"></small>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col 12 m6 l6 offset-l3 m3">
                          <textarea name="txtresultado_proyecto" class="materialize-textarea" length="1000" maxlength="1000" id="txtresultado_proyecto" ></textarea>
                          <label for="txtresultado_proyecto">Resultado del proyecto <span>*</span></label>
                          <small id="txtresultado_proyecto-error" class="error red-text"></small>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="divider"></div>
                  {{-- <div class="divider"></div> --}}
                  <div id="divEntidadesTecnoparque">
                    <center>
                      <div id="txtentidad_proyecto_id-error" class="error red-text"></div>
                    </center>
                    <div class="row">
                      <div class="col s12 m12 l12">
                        <center>
                          <a class="btn-floating blue-grey modal-trigger" href="#modalInformacioDeLaEntidadesEnProyecto"><i class="material-icons left">info_outline</i></a>
                          <span class="card-title center-align"><b>Datos de la Entidad con la que se articulará el proyecto.</b></span>
                        </center>
                      </div>
                    </div>
                    {{-- <div class="divider"></div> --}}
                    <div id="divEntidadEmpresaProyecto" class="row">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="txtnitEmpresa" id="txtnitEmpresa" value="{{ $entidad != "" ? $entidad->nit : "" }}" disabled>
                        <label for="txtnitEmpresa" class="active">Nit de la Empresa</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="txtnombreEmpresa" id="txtnombreEmpresa" value="{{ $entidad != "" ? $entidad->nombre : "" }}" disabled>
                        <label for="txtnombreEmpresa" class="active">Nombre de la Empresa</label>
                      </div>
                    </div>
                    <div id="divEntidadGrupoInvestigacionProyecto" class="row">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="txtcodigoGrupo" id="txtcodigoGrupo" value="{{ $entidad != "" ? $entidad->codigo_grupo : "" }}" disabled>
                        <label for="txtcodigoGrupo" class="active">Código del Grupo de Investigación</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="txtnombreGrupo" id="txtnombreGrupo" value="{{ $entidad != "" ? $entidad->nombre : "" }}" disabled>
                        <label for="txtnombreGrupo" class="active">Nombre del Grupo de Investigación</label>
                      </div>
                    </div>
                    <div id="divEntidadTecnoacademiaProyecto" class="row">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="txtcentroFormacion" id="txtcentroFormacion" value="{{ $entidad != "" ? $entidad->centro_formacion : "" }}" disabled>
                        <label for="txtcentroFormacion" class="active">Centro de Formación de la Tecnoacademia</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="txtnombreTecnoacademia" id="txtnombreTecnoacademia"  value="{{ $entidad != "" ? $entidad->nombre : "" }}" disabled>
                        <label for="txtnombreTecnoacademia" class="active">Nombre de la Tecnoacademia</label>
                      </div>
                    </div>
                    <div id="divEntidadNodoProyecto" class="row">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="txtCentroFormacionNodo" id="txtCentroFormacionNodo" value="{{ $entidad != "" ?  $entidad->centro : "" }}" disabled>
                        <label for="txtCentroFormacionNodo" class="active">Centro de Formación del Nodo</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="txtNombreNodo" id="txtNombreNodo"  value="{{ $entidad != "" ?  $entidad->nombre : "" }}" disabled>
                        <label for="txtNombreNodo" class="active">Nombre del Nodo</label>
                      </div>
                    </div>
                    <div id="divCentroFormacionProyecto" class="row">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="txtCodigoCentroFormacion" id="txtCodigoCentroFormacion" value="{{ $entidad != "" ?  $entidad->codigo_centro : "" }}" disabled>
                        <label for="txtCodigoCentroFormacion" class="active">Código del Centro de Formación</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="txtNombreCentroFormacion" id="txtNombreCentroFormacion"  value="{{ $entidad != "" ?  $entidad->nombre : "" }}" disabled>
                        <label for="txtNombreCentroFormacion" class="active">Nombre del Centro del Formación</label>
                      </div>
                    </div>
                    <div id="divUniversidadProyecto" class="row">
                      <div class="input-field col s12 m6 l6 offset-l3 m3">
                        <input type="text" name="txtuniversidad_proyecto" id="txtuniversidad_proyecto" onclick="editarNombreUniversidad(this.value);" value="{{ $proyecto->universidad_proyecto_edit }}" readonly>
                        <label for="txtuniversidad_proyecto" class="active">Universidad <span class="red-text">*</span></label>
                      </div>
                    </div>
                    <input type="hidden" name="txtentidad_proyecto_id" id="txtentidad_proyecto_id" value="{{ $proyecto->entidad_id }}">
                    {{-- <div id="txtentidad_proyecto_id-error" class="error red-text">Error</div> --}}
                  </div>
                  <div class="divider"></div>
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <center>
                        <a class="btn-floating blue-grey modal-trigger" href="#modalInformacioSobreLasIdeasDeProyecto_Proyecto"><i class="material-icons left">info_outline</i>Buscar</a>
                        <span class="black-text text-black">¿La idea de proyecto se aprobó en el CSIBT?</span>
                        <div class="switch m-b-md">
                          <label>
                            No
                            <input type="checkbox" name="txttipo_ideaproyecto" disabled {{ $proyecto->tipo_ideaproyecto == 1 ? 'checked' : '' }} id="txttipo_ideaproyecto" onchange="resetIdeaDeProyectoAsociadaAlProyecto();" value="1"/>
                            <span class="lever"></span>
                            Si
                          </label>
                        </div>
                      </center>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s12 m6 l6 offset-l3 m3">
                      <center>
                        <div class="card-panel grey lighten-3">
                          <div class="row">
                            <div class="input-field col s12 m12 l12">
                              <input type="text" id="txtnombreIdeaProyecto_Proyecto" name="txtnombreIdeaProyecto_Proyecto" value="{{ $proyecto->nombre_idea }}" readonly>
                              <label for="txtnombreIdeaProyecto_Proyecto">Idea de Proyecto</label>
                              <small id="txtidea_id-error" class="error red-text"></small>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12 m12 l12">
                              <input type="text" id="txtnombre" name="txtnombre" value="{{ $proyecto->nombre }}">
                              <label for="txtnombre">Nombre de Proyecto <span class="red-text">*</span></label>
                              <small id="txtnombre-error" class="error red-text"></small>
                            </div>
                          </div>
                        </div>
                      </center>
                      <input type="hidden" name="txtidea_id" id="txtidea_id" value="{{ $proyecto->idea_id }}">
                    </div>
                  </div>
                  <div class="divider"></div>
                  {{-- <div class="row"> --}}
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <center>
                        <a class="btn-floating blue-grey modal-trigger" href="#modalInformacioTalentosQueDesarrollaranElProyecto"><i class="material-icons left">info_outline</i></a>
                        <span class="card-title center-align"><b>Talentos que desarrollarán el proyecto.</b></span>
                      </center>
                    </div>
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
                                          <table id="talentosDeTecnoparque_ProyectoCreate_table" style="width: 100%">
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
                                                <th style="width: 15%">Talento Líder</th>
                                                <th style="width: 40%">Talento</th>
                                                <th style="width: 20%">Eliminar</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              @foreach ($pivot as $key => $value)
                                                {{-- {{$value}} --}}
                                                <tr id="talentoAsociadoAProyecto{{$value->talento_id}}">
                                                  <td><input type="radio" class="with-gap" {{$value->talento_lider == 1 ? 'checked' : ''}} name="radioTalentoLider" id="radioButton'{{$value->talento_id}}'" value="{{$value->talento_id}}"/><label for ="radioButton'{{$value->talento_id}}'"></label></td>
                                                  <td><input type="hidden" name="talentos[]" value="{{$value->talento_id}}">{{$value->talento}}</td>
                                                  <td><a class="waves-effect red lighten-3 btn" onclick="eliminar({{$value->talento_id}});"><i class="material-icons">delete_sweep</i></a></td>
                                                </tr>
                                              @endforeach
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
                    <div class="input-field col s12 m6 l6">
                      <textarea name="txtimpacto_proyecto" class="materialize-textarea" length="1000" maxlength="1000" id="txtimpacto_proyecto" >{{$proyecto->impacto_proyecto}}</textarea>
                      <label for="txtimpacto_proyecto">Impacto del proyecto</label>
                      <small id="txtimpacto_proyecto-error" class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <textarea  name="txtobservaciones_proyecto" class="materialize-textarea" length="1000" maxlength="1000" id="txtobservaciones_proyecto">{{$proyecto->observaciones_proyecto}}</textarea>
                      <label for="txtobservaciones_proyecto">Observaciones</label>
                      <small id="txtobservaciones_proyecto-error" class="error red-text"></small>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s6 m6 l6">
                      <span class="black-text text-black">Articulado con CT+i <span class="red-text">*</span></span>
                      <div class="switch m-b-md">
                        <label>
                          No
                          <input type="checkbox" {{$proyecto->art_cti == 'Si' ? 'checked' : ''}} name="txtarti_cti" id="txtarti_cti" value="1">
                          <span class="lever"></span>
                          Si
                        </label>
                      </div>
                    </div>
                    <div id="divNombreActorCTi" class="input-field col s6 m6 l6">
                      <input type="text" name="txtnom_act_cti" id="txtnom_act_cti" value="{{$proyecto->nom_act_cti}}">
                      <label for="txtnom_act_cti">Nombre del Actor CT+i <span class="red-text">*</span></label>
                      <small id="txtnom_act_cti-error" class="error red-text"></small>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s6 m6 l6">
                      <span class="black-text text-black">Dirigido a área de emprendimiento SENA <span class="red-text">*</span></span>
                      <div class="switch m-b-md">
                        <label>
                          No
                          <input type="checkbox" {{$proyecto->diri_ar_emp == 'Si' ? 'checked' : ''}} name="txtdiri_ar_emp" id="txtdiri_ar_emp" value="1">
                          <span class="lever"></span>
                          Si
                        </label>
                      </div>
                    </div>
                    <div class="col s6 m6 l6">
                      <span class="black-text text-black">Recibido a través del área de emprendimiento SENA <span class="red-text">*</span></span>
                      <div class="switch m-b-md">
                        <label>
                          No
                          <input type="checkbox" {{$proyecto->reci_ar_emp == 'Si' ? 'checked' : ''}} name="txtreci_ar_emp" id="txtreci_ar_emp" value="1">
                          <span class="lever"></span>
                          Si
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s6 m6 l6">
                      <span class="black-text text-black">Dinero de regalías <span class="red-text">*</span></span>
                      <div class="switch m-b-md">
                        <label>
                          No
                          <input type="checkbox" {{$proyecto->dine_reg == 'Si' ? 'checked' : ''}} name="txtdine_rega" id="txtdine_rega" value="1">
                          <span class="lever"></span>
                          Si
                        </label>
                      </div>
                    </div>
                    <div class="col s6 m6 l6">
                      <span class="black-text text-black">¿El proyecto pertenece a la economía naranja? <span class="red-text">*</span></span>
                      <div class="switch m-b-md">
                        <label>
                          No
                          <input type="checkbox" {{$proyecto->economia_naranja == 'Si' ? 'checked' : ''}} name="txteconomia_naranja" id="txteconomia_naranja" value="1">
                          <span class="lever"></span>
                          Si
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <center>
                    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
                    <a href="{{route('proyecto')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                  </center>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>
@include('proyectos.modals')
@endsection
@push('script')
  <script>
    $( document ).ready(function() {
      resetDatosEntidad();
    });

    function ajaxUpdateProyecto(form, data, url) {
      $('button[type="submit"]').attr('disabled', 'disabled');
      $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
          $('button[type="submit"]').removeAttr('disabled');
          // $('button[type="submit"]').prop("disabled", false);
          $('.error').hide();
          if (data.fail) {
              Swal.fire({
                title: 'Registro Erróneo',
                text: "Estas ingresando mal los datos!",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
              })
            for (control in data.errors) {
              $('#' + control + '-error').html(data.errors[control]);
              $('#' + control + '-error').show();
            }
          }
          if (data.revisado_final == 'Por Evaluar') {
            Swal.fire({
              title: 'Error!',
              text: "Para poder cerrar el proyecto, debe estar Aprobado o No Aprobado por el Dinamizador!",
              type: 'error',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            })
          }
          if ( data.result ) {
            Swal.fire({
              title: 'Modificación Exitosa',
              text: "El proyecto se modificado satisfactoriamente",
              type: 'success',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
            setTimeout(function(){
              window.location.replace("{{route('proyecto')}}");
            }, 1000);
          }
          if ( data.resulta == false ) {
            Swal.fire({
              title: 'Modificación Errónea!',
              text: "El proyecto no se ha modificado.",
              type: 'error',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        }
      });
    }

    //Enviar formulario
    $(document).on('submit', 'form#frmProyectosCreate', function (event) {
      // $('button[type="submit"]').prop("disabled", true);
      event.preventDefault();
      let id = $("#txtestadoproyecto_id").val();
      let nombre = $("#txtestadoproyecto_id [value='"+id+"']").text();

      var form = $(this);
      var data = new FormData($(this)[0]);
      var url = form.attr("action");

      if (nombre == "Cierre PF" || nombre == "Cierre PMV") {
        Swal.fire({
          title: 'Advertenica!',
          html: "<p class='red-text'>Una vez cerrado un proyecto, no podrás volver a modificar los datos de este!</br>"
          +"<b>¿Estás seguro(a) de cerrar este proyecto?</b></p>",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Cancelar',
          confirmButtonText: 'Sí, cerrar definitivamente!'
        }).then((result) => {
          if (result.value) {
            ajaxUpdateProyecto(form, data, url);
          }
        })
      } else {
        ajaxUpdateProyecto(form, data, url);
      }


    });


    // Contenedores
    divPreload = $('#divPreload');
    divEntidadEmpresaProyecto = $('#divEntidadEmpresaProyecto');
    divEntidadGrupoInvestigacionProyecto = $('#divEntidadGrupoInvestigacionProyecto');
    divEntidadTecnoacademiaProyecto = $('#divEntidadTecnoacademiaProyecto');
    divEntidadNodoProyecto = $('#divEntidadNodoProyecto');
    divCentroFormacionProyecto = $('#divCentroFormacionProyecto');
    divUniversidadProyecto = $('#divUniversidadProyecto');
    divNombreActorCTi = $('#divNombreActorCTi');
    divOtroTipoArticulacion = $('#divOtroTipoArticulacion');
    divEntidadesTecnoparque = $('#divEntidadesTecnoparque');
    divFechaCierreProyecto = $('#divFechaCierreProyecto');
    divOtroEstadoPrototipo = $('#divOtroEstadoPrototipo');


    // Ocultar contenedores
    divPreload.hide();
    divEntidadEmpresaProyecto.hide();
    divEntidadGrupoInvestigacionProyecto.hide();
    divEntidadTecnoacademiaProyecto.hide();
    divEntidadNodoProyecto.hide();
    divCentroFormacionProyecto.hide();
    divUniversidadProyecto.hide();
    divNombreActorCTi.hide();
    divOtroTipoArticulacion.hide();
    divEntidadesTecnoparque.hide();
    divFechaCierreProyecto.hide();
    divOtroEstadoPrototipo.hide();


    function setFechaCierreProyecto() {
      // console.log('fecha de cierre');
      let id = $("#txtestadoproyecto_id").val();
      let nombre = $("#txtestadoproyecto_id [value='"+id+"']").text();

      if (nombre == "Cierre PF" || nombre == "Cierre PMV") {
        divFechaCierreProyecto.show();
      } else {
        divFechaCierreProyecto.hide();
      }
    }

    @if($proyecto->art_cti == 'Si')
    divNombreActorCTi.show();
    @endif

    function resetDatosEntidad() {
      @if($proyecto->nombre_tipoarticulacion == 'Otro')
      divOtroTipoArticulacion.show();
      @endif

      @if ($proyecto->nombre_tipoarticulacion == 'Empresas')
      divEntidadEmpresaProyecto.show();
      @endif


      @if($proyecto->nombre_tipoarticulacion == 'Empresas')
      divEntidadEmpresaProyecto.show();
      @endif

      @if ($proyecto->nombre_tipoarticulacion == 'Grupos y Semilleros del Sena' || $proyecto->nombre_tipoarticulacion == 'Grupos y Semilleros Externos')
      divEntidadGrupoInvestigacionProyecto.show();
      @endif

      @if ($proyecto->nombre_tipoarticulacion == 'Tecnoacademias')
      divEntidadTecnoacademiaProyecto.show();
      @endif

      @if ($proyecto->nombre_tipoarticulacion == 'Tecnoparques')
      divEntidadNodoProyecto.show();
      @endif

      @if ($proyecto->nombre_tipoarticulacion == 'Centros de Formación')
      divCentroFormacionProyecto.show();
      @endif

      @if ($proyecto->nombre_tipoarticulacion == 'Universidades')
      divUniversidadProyecto.show();
      @endif

      @if ($proyecto->nombre_tipoarticulacion == 'Emprendedor' || $proyecto->nombre_tipoarticulacion == 'Proyecto financiado por SENNOVA' || $proyecto->nombre_tipoarticulacion == 'Otro')
      divEntidadesTecnoparque.hide();
      @else
      divEntidadesTecnoparque.show();
      @endif
    }

    $('#talentosDeTecnoparque_ProyectoCreate_table').DataTable({
      // "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      // order: false,
      ajax:{
        url: "/usuario/talento/getTalentosDeTecnoparque/",
        type: "get",
      },
      columns: [
      {
        data: 'documento',
        name: 'documento',
      },
      {
        data: 'talento',
        name: 'talento',
      },
      {
        data: 'add_proyecto',
        name: 'add_proyecto',
        orderable: false,
      },
      ],
    });



    function consultarEntidadesSegunElCaso(id) {
      let nombre = $("#txttipoarticulacionproyecto_id [value='"+id+"']").text();
      if (nombre == 'Empresas') {
        $('#entidadesTecnoparque_proyecto_table').dataTable().fnDestroy();
        $('#entidadesTecnoparque_proyecto_table').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          ajax:{
            url: "/proyecto/datatableEmpresasTecnoparque",
            type: "get",
          },
          columns: [
            {
              title: 'Nit de la Empresa',
              data: 'nit',
              name: 'nit',
            },
            {
              title: 'Nombre de la Empresa',
              data: 'nombre_empresa',
              name: 'nombre_empresa',
            },
            {
              width: '20%',
              data: 'checkbox',
              name: 'checkbox',
              orderable: false,
            },
          ],
        });
        $('#entidadesTecnoparque_modProyecto_modal').openModal({
          dismissible: false,
        });
      }

      if (nombre == 'Tecnoacademias') {
        $('#entidadesTecnoparque_proyecto_table').dataTable().fnDestroy();
        $('#entidadesTecnoparque_proyecto_table').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          ajax:{
            url: "/proyecto/datatableTecnoacademiasTecnoparque",
            type: "get",
          },
          select: true,
          columns: [
            {
              title: 'Centro de Formación',
              data: 'codigo',
              name: 'codigo',
            },
            {
              title: 'Nombre de la Tecnoacademia',
              data: 'nombre',
              name: 'nombre',
            },
            {
              // title: 'Seleccionar para asociar a proyecto',
              width: '20%',
              data: 'checkbox',
              name: 'checkbox',
              orderable: false,
            },
          ],
        });
        $('#entidadesTecnoparque_modProyecto_modal').openModal({
          dismissible: false,
        });

      }

      if (nombre == 'Tecnoparques') {
        $('#entidadesTecnoparque_proyecto_table').dataTable().fnDestroy();
        $('#entidadesTecnoparque_proyecto_table').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          ajax:{
            url: "/proyecto/datatableNodosTecnoparque",
            type: "get",
          },
          select: true,
          columns: [
            {
              title: 'Centro de Formación',
              data: 'centro',
              name: 'centro',
            },
            {
              title: 'Nombre del Nodo',
              data: 'nombre_nodo',
              name: 'nombre_nodo',
            },
            {
              // title: 'Seleccionar para asociar a proyecto',
              width: '20%',
              data: 'checkbox',
              name: 'checkbox',
              orderable: false,
            },
          ],
        });
        $('#entidadesTecnoparque_modProyecto_modal').openModal({
          dismissible: false,
        });

      }

      if (nombre == 'Centros de Formación') {
        $('#entidadesTecnoparque_proyecto_table').dataTable().fnDestroy();
        $('#entidadesTecnoparque_proyecto_table').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          ajax:{
            url: "/proyecto/datatableCentroFormacionTecnoparque",
            type: "get",
          },
          select: true,
          columns: [
            {
              title: 'Código del Centro de Formación',
              data: 'codigo_centro',
              name: 'codigo_centro',
            },
            {
              title: 'Nombre del Centro de Formación',
              data: 'nombre',
              name: 'nombre',
            },
            {
              // title: 'Seleccionar para asociar a proyecto',
              width: '20%',
              data: 'checkbox',
              name: 'checkbox',
              orderable: false,
            },
          ],
        });
        $('#entidadesTecnoparque_modProyecto_modal').openModal({
          dismissible: false,
        });

      }

      if (nombre == 'Grupos y Semilleros del SENA' || nombre == 'Grupos y Semilleros Externos') {
        let tipo_grupo = 0;
        if (nombre == 'Grupos y Semilleros del SENA') {
          tipo_grupo = 1;
        }
        $('#entidadesTecnoparque_proyecto_table').dataTable().fnDestroy();
        $('#entidadesTecnoparque_proyecto_table').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          ajax:{
            url: "/proyecto/datatableGruposInvestigacionTecnoparque/"+tipo_grupo,
            type: "get",
          },
          select: true,
          columns: [
            {
              title: 'Código del Grupo de Investigación',
              data: 'codigo_grupo',
              name: 'codigo_grupo',
            },
            {
              title: 'Nombre del  Grupo de Investigación',
              data: 'nombre',
              name: 'nombre',
            },
            {
              // title: 'Seleccionar para asociar a proyecto',
              width: '20%',
              data: 'checkbox',
              name: 'checkbox',
              orderable: false,
            },
          ],
        });
        $('#entidadesTecnoparque_modProyecto_modal').openModal({
          dismissible: false,
        });

      }

      if (nombre == 'Universidades') {
        Swal.fire({
          title: '¿Cuál es la universidad con la que se realizará el proyecto?',
          input: 'text',
          inputValue: "",
          showCancelButton: true,
          cancelButtonColor: '#d33',
          cancelButtonText: '<a class="white-text" onclick="volverSiElegirEntidad(); Swal.close()">Cancelar</a>',
          showCancelButton: true,
          inputValidator: (value) => {
            if (!value) {
              return 'El nombre de la universidad es obligatorio!'
            }
            if (value.length > 50) {
              return 'El nombre de la universidad debe ser máximo de 50 carácteres!'
            }
            if (value) {
              $('#txtuniversidad_proyecto').val(value);
              $("label[for='txtuniversidad_proyecto']").addClass('active');
              divUniversidadProyecto.show();
            }
          }
        })
      }

      // if (nombre == ) {
      //
      // }
    }

    /**
     * Método que muestra una alerta para ingresar otro estado de prototipo
     */
     function setOtroEstadoPrototipo(id) {
       let nombre = $("#txtestadoprototipo_id [value='"+id+"']").text();
       if (nombre == 'Otro.') {
         divOtroEstadoPrototipo.show();
       } else {
         divOtroEstadoPrototipo.hide();
       }
     }

    // Edita el nombre de la universidad que se asociará con el proyecto
    function editarNombreUniversidad(value) {
      Swal.fire({
        title: '¿Cuál es la universidad con la que se realizará el proyecto?',
        input: 'text',
        inputValue: value,
        showCancelButton: true,
        cancelButtonColor: '#d33',
        cancelButtonText: '<a class="white-text" onclick="volverSiElegirEntidad(); Swal.close()">Cancelar</a>',
        showCancelButton: true,
        inputValidator: (value) => {
          if (!value) {
            return 'Debes ingresar el nombre de una universidad!'
          }
          if (value) {
            $('#txtuniversidad_proyecto').val(value);
            $("label[for='txtuniversidad_proyecto']").addClass('active');
            divUniversidadProyecto.show();
          }
        }
      })
    }

    // En caso de que no se asocie ninguna entidad al proyecto
    function volverSiElegirEntidad() {
      divEntidadesTecnoparque.hide();
      resetDatosEntidad();
      $('#txttipoarticulacionproyecto_id').val({{ $proyecto->tipoarticulacionproyecto_id }});
      $('#txttipoarticulacionproyecto_id').material_select();
    }

    // Función para cerrar el modal y asignarle un valor al
    function asociarEmpresaAProyecto(id, nit, nombre) {
      // console.log(id);
      $('#entidadesTecnoparque_modProyecto_modal').closeModal();
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'La siguiente empresa se ha asociado al proyecto: ' + nit + ' - ' + nombre
      });
      $('#txtnombreEmpresa').val(nombre);
      $('#txtnitEmpresa').val(nit);
      $("label[for='txtnombreEmpresa']").addClass('active');
      $("label[for='txtnitEmpresa']").addClass('active');
      $('#txtentidad_proyecto_id').val(id);
      divEntidadEmpresaProyecto.show();
    }

    // Función para cerrar el modal y asignarle un valor al
    function asociarNodoAProyecto(id, codigo, nombre, centro) {
      // console.log(id);
      $('#entidadesTecnoparque_modProyecto_modal').closeModal();
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'El siguiente centro de formación se ha asociado al proyecto: ' + codigo + ' con el siguiente nodo ' + nombre
      });
      $('#txtCentroFormacionNodo').val(centro);
      $('#txtNombreNodo').val(nombre);
      $("label[for='txtCentroFormacionNodo']").addClass('active');
      $("label[for='txtNombreNodo']").addClass('active');
      $('#txtentidad_proyecto_id').val(id);
      divEntidadNodoProyecto.show();
    }

    // Función para cerrar el modal y asignarle un valor al
    function asociarCentroDeFormacionAProyecto(id, codigo, nombre) {
      // console.log(id);
      $('#entidadesTecnoparque_modProyecto_modal').closeModal();
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'El siguiente centro de formación se ha asociado al proyecto: ' + codigo + ' - ' + nombre
      });
      $('#txtCodigoCentroFormacion').val(codigo);
      $('#txtNombreCentroFormacion').val(nombre);
      $("label[for='txtCodigoCentroFormacion']").addClass('active');
      $("label[for='txtNombreCentroFormacion']").addClass('active');
      $('#txtentidad_proyecto_id').val(id);
      divCentroFormacionProyecto.show();
    }

    // Función para cerrar el modal y asignarle un valor al
    function asociarTecnoacademiaAProyecto(id, codigo, nombre, centro) {
      // console.log(id);
      $('#entidadesTecnoparque_modProyecto_modal').closeModal();
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        type: 'success',
        title: 'El siguiente centro de formación se ha asociado al proyecto: ' + codigo + ' con la siguiente tecnoacademia: ' + nombre
      });
      $('#txtcentroFormacion').val(centro);
      $('#txtnombreTecnoacademia').val(nombre);
      $("label[for='txtcentroFormacion']").addClass('active');
      $("label[for='txtnombreTecnoacademia']").addClass('active');
      $('#txtentidad_proyecto_id').val(id);
      divEntidadTecnoacademiaProyecto.show();
    }

    // Función para cerrar el modal y asignarle un valor al
    function asociarGrupoInvestigacionAProyecto(id, codigo, nombre) {
      // console.log(id);
      $('#entidadesTecnoparque_modProyecto_modal').closeModal();
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'El siguiente grupo de investigación se ha asociado al proyecto: ' + codigo + ' - ' + nombre
      });
      $('#txtnombreGrupo').val(nombre);
      $('#txtcodigoGrupo').val(codigo);
      $("label[for='txtnombreGrupo']").addClass('active');
      $("label[for='txtcodigoGrupo']").addClass('active');
      $('#txtentidad_proyecto_id').val(id);
      divEntidadGrupoInvestigacionProyecto.show();
    }

    $('#txttipoarticulacionproyecto_id').change(function (){
      let id =  $("#txttipoarticulacionproyecto_id").val();
      let nombre = $("#txttipoarticulacionproyecto_id [value='"+id+"']").text();
      if (nombre == 'Otro') {
        divOtroTipoArticulacion.show();
      } else {
        divOtroTipoArticulacion.hide();
      }

      if (nombre != 'Empresas') {
        divEntidadEmpresaProyecto.hide();
      }

      if (nombre == 'Empresas') {
        divEntidadEmpresaProyecto.show();
      }

      if (nombre != 'Grupos y Semilleros del Sena' || nombre != 'Grupos y Semilleros Externos') {
        divEntidadGrupoInvestigacionProyecto.hide();
      }

      if (nombre != 'Tecnoacademias') {
        divEntidadTecnoacademiaProyecto.hide();
      }

      if (nombre != 'Tecnoparques') {
        divEntidadNodoProyecto.hide();
      }

      if (nombre != 'Centros de Formación') {
        divCentroFormacionProyecto.hide();
      }

      if (nombre != 'Universidades') {
        divUniversidadProyecto.hide();
      }

      if (nombre == 'Emprendedor' || nombre == 'Proyecto financiado por SENNOVA' || nombre == 'Otro') {
        divEntidadesTecnoparque.hide();
      } else {
        divEntidadesTecnoparque.show();
      }
    });

    $('#txtarti_cti').change(function() {
      if ( $('#txtarti_cti').is(':checked') ) {
        divNombreActorCTi.show();
      } else {
        divNombreActorCTi.hide();
      }
    });

    function noRepeat(id) {
      let idTalento = id;
      let retorno = true;
      let a = document.getElementsByName("talentos[]");
      for (x=0;x<a.length;x++){
        if (a[x].value == idTalento) {
          retorno = false;
          break;
        }
      }
      return retorno;
    }

    // Método para agregar talentos a una articulación
    function addTalentoProyecto(id) {
      if (noRepeat(id) == false) {
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 1500,
          type: 'warning',
          title: 'El talento ya se encuentra asociado al proyecto!'
        });
      } else {
        // let talentos = document.getElementsByName("talentos[]");
        $.ajax({
          dataType:'json',
          type:'get',
          url:'/usuario/talento/consultarTalentoPorId/'+id,
        }).done(function(ajax){
          // <input type="text" id="rolTalento'+idTalento+'" value="" readonly>
          // El ajax.talento.id es el id del TALENTO, no del usuario
          let idTalento = ajax.talento.id;
          let fila = '<tr class="selected" id=talentoAsociadoAProyecto'+idTalento+'>'
          +'<td><input type="radio" class="with-gap" name="radioTalentoLider" id="radioButton'+id+'" value="'+idTalento+'" /><label for ="radioButton'+idTalento+'"></label></td>'
          +'<td><input type="hidden" name="talentos[]" value="'+idTalento+'">'+ajax.talento.documento+' - '+ajax.talento.talento+'</td>'
          +'<td><a class="waves-effect red lighten-3 btn" onclick="eliminar('+idTalento+');"><i class="material-icons">delete_sweep</i></a></td>'
          +'</tr>';
          $('#detalleTalentosDeUnProyecto_Create').append(fila);
          Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            type: 'success',
            title: 'El talento se ha asociado al proyecto!'
          });
        });
      }
    }

    function eliminar(index){
      $('#talentoAsociadoAProyecto'+index).remove();
    }

  </script>
@endpush
