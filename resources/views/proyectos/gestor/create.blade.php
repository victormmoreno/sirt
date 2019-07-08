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
                  <span class="card-title center-align">Nuevo Proyecto</span>
                </center>
                <div class="divider"></div>
                <div class="card-panel red lighten-3">
                  <div class="card-content white-text">
                    <a class="btn-floating red"><i class="material-icons left">info_outline</i></a><span>Los elementos con (*) son obligatorios</span>
                  </div>
                </div>
                <br />
                <form action=""  method="POST">
                  <div class="row">
                    <div class="input-field col s12 m12 l12">
                      <select class="js-states" id="txttipoproyecto" name="txttipoproyecto">
                        <option value="">Seleccione el Tipo de Proyecto</option>

                      </select>
                      <label>Tipo de Proyecto <span class="red-text">*</span></label>
                    </div>
                  </div>
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
                    <div class="input-field col s12 m6 l6">
                      <small>Foco <span class="red-text">*</span></small>
                      <select id="txtfoco" class="js-states" name="txtfoco" style="width: 100%">
                        <option value="">Seleccione el Foco</option>

                      </select>
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <small>Sector <span class="red-text">*</span></small>
                      <select id="txtsector" class="js-states" name="txtsector" style="width: 100%;">
                        <option value="">Seleccione el Sector</option>

                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <select id="txtestadoproyecto" name="txtestadoproyecto" style="width: 100%;">
                        <option value="">Seleccione el Estado del Proyecto</option>

                      </select>
                      <label for="txtestadoproyecto">Estado del Proyecto <span class="red-text">*</span></label>
                      <!-- <label>Estado del Proyecto *</label> -->
                    </div>
                    <div id="fechaFinVigilancia">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="fechacierre_vigilancia" id="fechacierre_vigilancia" class="passdatepicker picker__input">
                        <label for="fechacierre_vigilancia">Fecha de Fin <span class="red-text">*</span></label>
                      </div>
                    </div>
                  </div>
                  <div id="divNit">
                    <div class="divider"></div>
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input id="txtnit" name="txtnit" class="empresaDatos" type="text" maxlength="15" required>
                        <label for="txtnit">Nit <span class="red-text">*</span></label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input id="txtrazonsocial" name="txtrazonsocial" class="empresaDatos" maxlength="45" type="text" required>
                        <label for="txtrazonsocial">Razón Social <span class="red-text">*</span></label>
                      </div>
                    </div>
                  </div>
                  <div id="divGruposInvestigacion">
                    <div class="divider"></div>
                    <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <label for="txtgrupoinvestigacion" class="active">Grupo de Investigación <span class="red-text">*</span></label>
                        <select class="js-states browser-default select2" style="width: 100%;" name="txtgrupoinvestigacion" id="txtgrupoinvestigacion">
                          <option value="">Seleccione un Grupo de Investigación</option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="institucionGrupo" id="institucionGrupo" disabled id="institucionGrupo" value="">
                        <label for="institucionGrupo" id="labelinsGrupo">Institución <span class="red-text">*</span></label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="clasificacionGrupo" id="clasificacionGrupo" disabled id="clasificacionGrupo">
                        <label for="clasificacionGrupo" id="labelclaGrupo">Clasificación <span class="red-text">*</span></label>
                      </div>
                    </div>
                  </div>
                  <div id="preguntaIdea">
                    <div class="divider"></div>
                    <div class="row">
                      <div class="col s12 m12 l12">
                        <center>
                          <span class="black-text text-black">¿Viene de una idea de proyecto?</span>
                          <div class="switch m-b-md">
                            <label>
                              No
                              <input type="checkbox" name="ideaProyecto" id="ideaProyecto" value="1"/>
                              <span class="lever"></span>
                              Si
                            </label>
                          </div>
                        </center>
                      </div>
                    </div>
                    <div id="ideaEmpresa">
                      <div class="row">
                        <div class="input-field col s11 m11 l11">
                          <!-- <label class="active">Idea de Proyecto (CON EMPRESA) <span class="red-text">*</span></label> -->

                        </div>
                        <div class="col s1 m1 l1">
                          <a class="waves-effect waves-blue btn-floating m-b-xs blue tooltipped" data-position="bottom" data-delay="50" data-tooltip="Únicamente se estan mostrando las ideas de proyecto vinculadas con EMPRESAS">
                            <i class="material-icons">help_outline</i>
                          </a>
                        </div>
                      </div>
                    </div>
                    <div id="ideaAprobada">
                      <div class="row">
                        <div class="input-field col s11 m11 l11">
                          <label class="active">Idea de Proyecto <span class="red-text">*</span></label>
                          <select class="js-states browser-default select2" style="width: 100%;" name="txtideaproyecto" id="txtideaproyecto">
                            <option value="">Seleccione una Idea de Proyecto <span class="red-text">*</span></option>
                          </select>
                        </div>
                        <div class="col s1 m1 l1">
                          <a class="waves-effect waves-blue btn-floating m-b-xs blue tooltipped" data-position="bottom" data-delay="50" data-tooltip="Únicamente se estan mostrando las ideas de proyecto que se APROBARON en el CSBIT">
                            <i class="material-icons">help_outline</i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="nombreFechaVigilancia">
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="txtnombreproyecto"  id="txtnombreproyecto" required class="validate" maxlength="200">
                        <label id="labelNombreProyecto" for="txtnombreproyecto">Nombre del Proyecto <span class="red-text">*</span></label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="fecha_crea" id="fecha_crea" value="<?= date("Y-m-d"); ?>" class="datepicker picker__input">
                        <label for="fecha_crea">Fecha de Inicio <span class="red-text">*</span></label>
                      </div>
                    </div>
                    <div class="input-field col m12 s12 l12">
                      <select id="txtcedulalider" style="width: 100%;" class="js-states browser-default select2" required name="txtcedulalider">
                        <option value="">Seleccione el Talento Líder</option>

                      </select>
                      <label class="active">Talento Líder <span class="red-text">*</span></label>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                      <div class="col s12 m12 l12">
                        <div class="card-content">
                          <h5>
                            <span class="red-text text-darken-2">Para registrar los talentos dar click en el botón <a class="btn-floating waves-effect waves-light red"><i class="material-icons">add</i></a></span>
                          </h5>
                          <p>Si desea agregar mas integrantes al proyecto por favor seleccione..</p>
                          <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                            <li>
                              <div class="collapsible-header active blue-grey lighten-1"><i class="material-icons">people</i>Seleccione los Talentos que participarán en el proyecto</div>
                              <div class="collapsible-body">
                                <div class="card-content">
                                  <div class="row">
                                    <div class="input-field col s10 m10 l10">
                                      <select id="txttalento" class="js-states browser-default select2" style="width: 100%;" required name="txttalento" onchange="noRepeat()" >
                                        <option value="0">Seleccione los Talentos que participarán en el proyecto</option>

                                      </select>
                                      <label for="#txttalento" class="active">Talentos <span class="red-text">*</span></label>
                                    </div>
                                    <div class="col s2 m2 l2">
                                      <a onclick="agregar()" class="btn-floating btn-large waves-effect waves-light indigo lighten-2 tooltipped" data-position="bottom" data-delay="50" data-tooltip="Agregar el talento seleccionado al proyecto"><i class="material-icons">add</i></a>
                                    </div>
                                  </div>
                                  <div class="card-content">
                                    <table id="detalles" class="striped">
                                      <thead>
                                        <tr>
                                          <th style="width: 80%">Talento</th>
                                          <th style="width: 20%">Eliminar</th>
                                        </tr>
                                      </thead>
                                      <tbody>

                                      </tbody>
                                    </table>
                                  </div>
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
                        <textarea name="txtdescripcion" class="materialize-textarea" length="400" maxlength="400" id="txtdescripcion" ></textarea>
                        <label for="txtdescripcion">Descripción del proyecto</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <textarea  name="txtobservaciones" class="materialize-textarea" length="200" maxlength="200" id="txtobservaciones"></textarea>
                        <label for="txtobservaciones">Observaciones</label>
                      </div>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <div class="row">
                    <div class="col s6 m6 l6">
                      <span class="black-text text-black">Articulado con CT+i <span class="red-text">*</span></span>
                      <div class="switch m-b-md">
                        <label>
                          No
                          <input type="checkbox" name="txtarti_cti" id="txtarti_cti" value="1">
                          <span class="lever"></span>
                          Si
                        </label>
                      </div>
                    </div>
                    <div id="divNombreActorCTi" class="input-field col s6 m6 l6">
                      <input type="text" name="nom_act_cti" id="nom_act_cti" value="">
                      <label for="nom_act_cti">Nombre del Actor CT+i<span class="red-text">*</span></label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s6 m6 l6">
                      <span class="black-text text-black">Dirigido a área de emprendimiento SENA <span class="red-text">*</span></span>
                      <div class="switch m-b-md">
                        <label>
                          No
                          <input type="checkbox" name="txtdiri_ar_emp" id="txtdiri_ar_emp" value="1">
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
                          <input type="checkbox" name="txtreci_ar_emp" id="txtreci_ar_emp" value="1">
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
                          <input type="checkbox" name="txtdine_rega" id="txtdine_rega" value="1">
                          <span class="lever"></span>
                          Si
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <center>
                    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>Registrar</button>
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
@endsection
@push('script')
  <script>
  divNombreActorCTi = $('#divNombreActorCTi');
  divNombreActorCTi.hide();
  // function nombreActorCTi() {
  //   alert( "Handler for .change() called." );
  // }
    $('#txtarti_cti').change(function() {
      if ( $('#txtarti_cti').is(':checked') ) {
        divNombreActorCTi.show();
      } else {
        divNombreActorCTi.hide();
      }
    });
  </script>
@endpush
