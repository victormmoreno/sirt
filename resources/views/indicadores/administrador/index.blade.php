@extends('layouts.app')
@section('meta-title', 'Indicadores')
@section('content')
  @php
  $now = Carbon\Carbon::now();
  $yearNow = $now->year;
  $monthNow = $now->month;
  @endphp
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5>
            <i class="material-icons left">info_outline</i>Indicadores
          </h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <div class="center-align">
                        <span class="card-title center-align">Indicadores</span>
                      </div>
                    </div>
                  </div>
                  <div class="row card-panel teal lighten-5">
                    <h6>Para consultar TODOS los indicadores, debes seleccionar un nodo, un rango de fechas y luego presionar el botón de descarga.</h6>
                    <div class="input-field col s12 m4 l4">
                      <select class="js-states select2 browser-default" name="txtnodo_id" id="txtnodo_id" style="width: 100%">
                        @foreach($nodos as $nodo)
                          <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                        @endforeach
                      </select>
                      <label for="txtnodo_id" class="active">Seleccione el Nodo</label>
                    </div>
                    <div class="input-field col s12 m3 l3">
                      <input type="text" id="txtfecha_inicio_todos" name="txtfecha_inicio_todos" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                      <label for="txtfecha_inicio_todos">Fecha Inicio</label>
                    </div>
                    <div class="input-field col s12 m3 l3">
                      <input type="text" id="txtfecha_fin_todos" name="txtfecha_fin_todos" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                      <label for="txtfecha_fin_todos">Fecha Fin</label>
                    </div>
                    <div class="center input-field col s12 m2 l2">
                      <a onclick="generarExcelConTodosLosIndicadores(1);" class="btn"><i class="material-icons">file_download</i></a>
                    </div>
                  </div>
                  <div class="row">
                    <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                      <li class="tab col s3"><a class="active" href="#indicadores_proyectos">Proyectos</a></li>
                      <li class="tab col s3"><a class="" href="#indicadores_articulaciones">Articulaciones con empresas y emprendedores</a></li>
                      <li class="tab col s3"><a class="" href="#indicadores_edts">EDT's</a></li>
                      <li class="tab col s3"><a class="" href="#indicadores_talentos">Talentos</a></li>
                    </ul>
                    <br>
                  </div>
                  <div class="divider"></div>
                  <div id="indicadores_proyectos" class="row">
                    <div class="col s12 m6 l6">
                      <ul class="collapsible">
                        <li id="indicador1">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número de proyectos inscritos.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de proyectos inscritos en un rango de fecha.
                                <br>
                                Para consultar el total de proyectos inscritos, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind1" name="txtfecha_inicio_ind1" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind1">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind1" name="txtfecha_fin_ind1" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind1">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarProyectosInscritos_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind1" name="txt_total_ind1" value="" disabled>
                                  <label for="txt_total_ind1" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador2">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número de proyectos en ejecución.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de proyectos en ejecución.
                                <br>
                                Para consultar el total de proyectos en ejecución debes presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m6 l6 offset-m3 offset-l3">
                                {{-- <div class="input-field col s12 m12 l12"> --}}
                                  <input type="text" id="txt_total_ind2" name="txt_total_ind2" value="" disabled>
                                  <label for="txt_total_ind2" class="active">Total</label>
                                {{-- </div> --}}
                                <div class="center">
                                  <button onclick="consultarProyectosEnEjecucion_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador3">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número total de PFF finalizados.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de PFF en finalizados en un rango de fecha.
                                <br>
                                Para consultar el total de PFF finalizados, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind3" name="txtfecha_inicio_ind3" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind3">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind3" name="txtfecha_fin_ind3" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind3">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarPFFfinalizados_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind3" name="txt_total_ind3" value="" disabled>
                                  <label for="txt_total_ind3" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador4">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número proyectos con SENA (aprendiz, instructor) inscritos en el presente mes.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de proyectos inscritos con aprediz o instructor sena en un rango de fecha.
                                <br>
                                Para consultar la cantidad de proyectos inscritos con SENA (aprendiz, instructor), debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind4" name="txtfecha_inicio_ind4" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind4">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind4" name="txtfecha_fin_ind4" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind4">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarProyectosInscritosAprendizInstructor_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind4" name="txt_total_ind4" value="" disabled>
                                  <label for="txt_total_ind4" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador5">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número de proyectos en ejecución con SENA (Aprendiz, Instructor).</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de proyectos en ejecución con SENA (Aprendiz, Insctructor).
                                <br>
                                Para consultar el total de proyectos en ejecución con al menos un talento SENA (Aprendiz, Instructor) debes presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m6 l6 offset-m3 offset-l3">
                                {{-- <div class="input-field col s12 m12 l12"> --}}
                                  <input type="text" id="txt_total_ind5" name="txt_total_ind5" value="" disabled>
                                  <label for="txt_total_ind5" class="active">Total</label>
                                {{-- </div> --}}
                                <div class="center">
                                  <button onclick="consultarProyectosEnEjecucionConSena_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador6">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número PFF con SENA (aprendiz, instructor) finalizados.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de PFF finalizados con aprediz o instructor SENA en un rango de fecha.
                                <br>
                                Para consultar la cantidad de PFF finalizados con SENA (aprendiz, instructor), debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind6" name="txtfecha_inicio_ind6" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind6">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind6" name="txtfecha_fin_ind6" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind6">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarProyectosPFFFinalizadosAprendizInstructor_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind6" name="txt_total_ind6" value="" disabled>
                                  <label for="txt_total_ind6" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador7">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Valor total de costos estimados de los PFF finalizados con SENA (Aprendiz, Instructor).</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el costo total de los PFF finalizados con SENA.
                                <br>
                                Para consultar el costo total de PFF finalizados con SENA (aprendiz, instructor), debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind7" name="txtfecha_inicio_ind7" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind7">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind7" name="txtfecha_fin_ind7" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind7">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarCostosPFFfinalizadosSena_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind7" name="txt_total_ind7" value="" disabled>
                                  <label for="txt_total_ind7" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador8">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número de proyectos inscritos con empresas.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el número de proyectos inscritos con empresas.
                                <br>
                                Para consultar el número de proyectos inscritos con empresas, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind8" name="txtfecha_inicio_ind8" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind8">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind8" name="txtfecha_fin_ind8" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind8">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarProyectosInscritosEmpresas_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind8" name="txt_total_ind8" value="" disabled>
                                  <label for="txt_total_ind8" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador9">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número de proyectos en ejecución con empresas.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de proyectos en ejecución con empresas.
                                <br>
                                Para consultar el total de proyectos en ejecución con empresas debes presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m6 l6 offset-m3 offset-l3">
                                {{-- <div class="input-field col s12 m12 l12"> --}}
                                  <input type="text" id="txt_total_ind9" name="txt_total_ind9" value="" disabled>
                                  <label for="txt_total_ind9" class="active">Total</label>
                                {{-- </div> --}}
                                <div class="center">
                                  <button onclick="consultarProyectosEnEjecucionConEmpresas_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador10">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número de PFF finalizados empresas.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el número de PFF finalizados con empresas.
                                <br>
                                Para consultar el número de PFF finalizados con empresas, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind10" name="txtfecha_inicio_ind10" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind10">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind10" name="txtfecha_fin_ind10" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind10">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarProyectosPFFFinalizadosEmpresas_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind10" name="txt_total_ind10" value="" disabled>
                                  <label for="txt_total_ind10" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador11">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Valor total de costos estimados de los PFF finalizados con empresas.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el costo total de los PFF finalizados.
                                <br>
                                Para consultar el costo total de PFF finalizados con empresas, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind11" name="txtfecha_inicio_ind11" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind11">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind11" name="txtfecha_fin_ind11" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind11">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarCostosPFFfinalizadosEmpresas_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind11" name="txt_total_ind11" value="" disabled>
                                  <label for="txt_total_ind11" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador12">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Aprendices en asocio al desarrollo de proyectos con empresas.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de aprendices en asocio al desarrollo de proyectos con empresas.
                                <br>
                                Para consultar la cantidad de aprendices en asocio al desarrollo de proyectos con empresas, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind12" name="txtfecha_inicio_ind12" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind12">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind12" name="txtfecha_fin_ind12" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind12">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarTalentoEnAsocioProyectosConEmpresa_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind12" name="txt_total_ind12" value="" disabled>
                                  <label for="txt_total_ind12" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador13">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número de proyectos inscritos con emprendedores y otros.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de proyectos inscritos con emprededores y otros.
                                <br>
                                Para consultar la cantidad de proyectos inscritos con emprendedores y otros, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind13" name="txtfecha_inicio_ind13" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind13">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind13" name="txtfecha_fin_ind13" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind13">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarProyectosInscritosEmprendedoresInvetoresOtros_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind13" name="txt_total_ind13" value="" disabled>
                                  <label for="txt_total_ind13" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador14">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número de proyectos en ejecución con emprendores y otros.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de proyectos en ejecución con emprendores y otros.
                                <br>
                                Para consultar el total de proyectos en ejecución con emprendores y otros debes presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m6 l6 offset-m3 offset-l3">
                                {{-- <div class="input-field col s12 m12 l12"> --}}
                                  <input type="text" id="txt_total_ind14" name="txt_total_ind14" value="" disabled>
                                  <label for="txt_total_ind14" class="active">Total</label>
                                {{-- </div> --}}
                                <div class="center">
                                  <button onclick="consultarProyectosEnEjecucionConEmprendedoresInventoresOtros_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador15">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número de PFF finalizados con emprendedores y otros.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de PFF finalizados con emprededores y otros.
                                <br>
                                Para consultar la cantidad de PFF finalizados inscritos con emprendedores y otros, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind15" name="txtfecha_inicio_ind15" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind15">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind15" name="txtfecha_fin_ind15" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind15">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarPFFFinalizadosEmprendedoresInvetoresOtros_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind15" name="txt_total_ind15" value="" disabled>
                                  <label for="txt_total_ind15" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                    <div class="col s12 m6 l6">
                      <ul class="collapsible">
                        <li id="indicador16">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Valor total de costos estimados de los PFF finalizados con emprendedores y otros.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el total de costos de PFF finalizados con emprededores y otros.
                                <br>
                                Para consultar el total de costos de PFF finalizados inscritos con emprendedores y otros, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind16" name="txtfecha_inicio_ind16" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind16">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind16" name="txtfecha_fin_ind16" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind16">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarCostosPFFfinalizadosEmprendedoresOtros_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind16" name="txt_total_ind16" value="" disabled>
                                  <label for="txt_total_ind16" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador17">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número total de PMV finalizados.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de PMV en finalizados en un rango de fecha.
                                <br>
                                Para consultar el total de PMV finalizados, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind17" name="txtfecha_inicio_ind17" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind17">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind17" name="txtfecha_fin_ind17" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind17">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarPMVfinalizados_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind17" name="txt_total_ind17" value="" disabled>
                                  <label for="txt_total_ind17" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador18">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número PMV con SENA (aprendiz, instructor) finalizados.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de PMV finalizados con aprediz o instructor SENA en un rango de fecha.
                                <br>
                                Para consultar la cantidad de PMV finalizados con SENA (aprendiz, instructor), debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind18" name="txtfecha_inicio_ind18" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind18">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind18" name="txtfecha_fin_ind18" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind18">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarProyectosPMVFinalizadosAprendizInstructor_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind18" name="txt_total_ind18" value="" disabled>
                                  <label for="txt_total_ind18" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador19">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Valor total de costos estimados de los PMV finalizados con SENA (Aprendiz, Instructor).</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el costo total de los PMV finalizados.
                                <br>
                                Para consultar el costo total de PMV finalizados con SENA (aprendiz, instructor), debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind19" name="txtfecha_inicio_ind19" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind19">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind19" name="txtfecha_fin_ind19" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind19">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarCostosPMVfinalizadosSena_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind19" name="txt_total_ind19" value="" disabled>
                                  <label for="txt_total_ind19" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador20">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número de PMV finalizados empresas.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el número de PMV finalizados con empresas.
                                <br>
                                Para consultar el número de PMV finalizados con empresas, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind20" name="txtfecha_inicio_ind20" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind20">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind20" name="txtfecha_fin_ind20" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind20">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarProyectosPMVFinalizadosEmpresas_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind20" name="txt_total_ind20" value="" disabled>
                                  <label for="txt_total_ind20" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador21">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Valor total de costos estimados de los PMV finalizados con empresas.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el costo total de los PMV finalizados.
                                <br>
                                Para consultar el costo total de PMV finalizados con empresas, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind21" name="txtfecha_inicio_ind21" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind21">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind21" name="txtfecha_fin_ind21" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind21">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarCostosPMVfinalizadosEmpresas_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind21" name="txt_total_ind21" value="" disabled>
                                  <label for="txt_total_ind21" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador22">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número de PMV finalizados con emprendedores y otros.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de PMV finalizados con emprededores y otros.
                                <br>
                                Para consultar la cantidad de PMV finalizados inscritos con emprendedores y otros, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind22" name="txtfecha_inicio_ind22" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind22">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind22" name="txtfecha_fin_ind22" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind22">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarPMVFinalizadosEmprendedoresInvetoresOtros_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind22" name="txt_total_ind22" value="" disabled>
                                  <label for="txt_total_ind22" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador23">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Valor total de costos estimados de los PMV finalizados con emprendedores y otros.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el total de costos de PMV finalizados con emprededores y otros.
                                <br>
                                Para consultar el total de costos de PMV finalizados inscritos con emprendedores y otros, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind23" name="txtfecha_inicio_ind23" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind23">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind23" name="txtfecha_fin_ind23" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind23">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarCostosPMVfinalizadosEmprendedoresOtros_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind23" name="txt_total_ind23" value="" disabled>
                                  <label for="txt_total_ind23" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador24">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número de proyectos articulados con Grupos de Investigación Internos.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el número de proyectos articulados con grupo de investigación internos (SENA).
                                <br>
                                Para consultar el número de proyectos articulados con grupo de investigación internos (SENA), debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind24" name="txtfecha_inicio_ind24" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind24">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind24" name="txtfecha_fin_ind24" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind24">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarProyectoConGruposInternos_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind24" name="txt_total_ind24" value="" disabled>
                                  <label for="txt_total_ind24" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador25">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número de proyectos articulados con Grupos de Investigación Internos finalizados.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el número de proyectos articulados con grupo de investigación internos (SENA) finalizados.
                                <br>
                                Para consultar el número de proyectos articulados con grupo de investigación internos (SENA) finalizados, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind25" name="txtfecha_inicio_ind25" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind25">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind25" name="txtfecha_fin_ind25" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind25">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarProyectoConGruposInternosFinalizados_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind25" name="txt_total_ind25" value="" disabled>
                                  <label for="txt_total_ind25" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador26">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número de proyectos articulados con Grupos de Investigación Externos.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el número de proyectos articulados con grupo de investigación externos.
                                <br>
                                Para consultar el número de proyectos articulados con grupo de investigación externos, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind26" name="txtfecha_inicio_ind26" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind26">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind26" name="txtfecha_fin_ind26" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind26">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarProyectoConGruposExternos_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind26" name="txt_total_ind26" value="" disabled>
                                  <label for="txt_total_ind26" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador27">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número de proyectos articulados con Grupos de Investigación Externos finalizados.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el número de proyectos articulados con grupo de investigación externos finalizados.
                                <br>
                                Para consultar el número de proyectos articulados con grupo de investigación externos finalizados, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind27" name="txtfecha_inicio_ind27" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind27">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind27" name="txtfecha_fin_ind27" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind27">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarProyectoConGruposExternosFinalizados_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind27" name="txt_total_ind27" value="" disabled>
                                  <label for="txt_total_ind27" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador28">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número de Aprendices articulados con proyectos del Nodo y CON Apoyo de Sostenimiento activos.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el número de aprendices articulacion con proyectos y con apoyo de sostenimiento.
                                <br>
                                Para consultar el número de aprendices articulacion con proyectos y con apoyo de sostenimiento, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind28" name="txtfecha_inicio_ind28" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind28">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind28" name="txtfecha_fin_ind28" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind28">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarTalentosConApoyoYProyectos_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind28" name="txt_total_ind28" value="" disabled>
                                  <label for="txt_total_ind28" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador29">
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número de Aprendices articulados con proyectos del Nodo y SIN Apoyo de Sostenimiento activos.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el número de aprendices articulacion con proyectos y sin apoyo de sostenimiento.
                                <br>
                                Para consultar el número de aprendices articulacion con proyectos y sin apoyo de sostenimiento, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind29" name="txtfecha_inicio_ind29" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind29">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind29" name="txtfecha_fin_ind29" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind29">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarTalentosSinApoyoYProyectos_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind29" name="txt_total_ind29" value="" disabled>
                                  <label for="txt_total_ind29" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div id="indicadores_articulaciones" class="row">
                    <div class="col s12 m6 l6">
                      <ul class="collapsible">
                        <li id="indicador30">
                          <div class="collapsible-header"><i class="material-icons">autorenew</i>Asesoría I+D+i inscritas con empresas y emprendedores.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el número de asesorías I+D+i inscritas con empresas y emprendedores.
                                <br>
                                Para consultar el número de asesorías I+D+i inscritas con empresas y emprendedores, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind30" name="txtfecha_inicio_ind30" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind30">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind30" name="txtfecha_fin_ind30" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind30">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarAsesoriasIDiEmp_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind30" name="txt_total_ind30" value="" disabled>
                                  <label for="txt_total_ind30" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador31">
                          <div class="collapsible-header"><i class="material-icons">autorenew</i>Asesoría I+D+i en ejecución con empresas y emprendedores.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de asesorías I+D+i con empresas y emprendedores (Articulaciones con empresas y emprendedores) en ejecución.
                                <br>
                                Para consultar el total de asesorías I+D+i con empresas y emprendedores en ejecución debes presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m6 l6 offset-m3 offset-l3">
                                {{-- <div class="input-field col s12 m12 l12"> --}}
                                  <input type="text" id="txt_total_ind31" name="txt_total_ind31" value="" disabled>
                                  <label for="txt_total_ind31" class="active">Total</label>
                                {{-- </div> --}}
                                <div class="center">
                                  <button onclick="consultarAsesoriasIDiEmpresasEmprendedoresEnEjecucion_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador32">
                          <div class="collapsible-header"><i class="material-icons">autorenew</i>Asesoría I+D+i finalizadas con empresas y emprendedores.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de asesorías I+D+i con empresas y emprendedores (Articulaciones con empresas y emprendedores) finalizadas.
                                <br>
                                Para consultar el total de asesorías I+D+i con empresas y emprendedores finalizadas, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind32" name="txtfecha_inicio_ind32" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind32">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind32" name="txtfecha_fin_ind32" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind32">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarAsesoriasIDiEmpresasEmprendedoresFinalizadas_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind32" name="txt_total_ind32" value="" disabled>
                                  <label for="txt_total_ind32" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador33">
                          <div class="collapsible-header"><i class="material-icons">autorenew</i>Vigilancías Tecnológicas finalizadas con empresas y emprendedores.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de vigilancías tecnológicas finalizadas con empresas y emprendedores.
                                <br>
                                Para consultar el total de vigilancías tecnológicas finalizadas con empresas y emprendedores, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind33" name="txtfecha_inicio_ind33" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind33">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind33" name="txtfecha_fin_ind33" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind33">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarVigilanciaEmpresasEmprendedoresFinalizadas_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind33" name="txt_total_ind33" value="" disabled>
                                  <label for="txt_total_ind33" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador34">
                          <div class="collapsible-header"><i class="material-icons">autorenew</i>Análisis de Prospectiva finalizadas con empresas y emprendedores.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de análisis de prospectiva finalizadas con empresas y emprendedores.
                                <br>
                                Para consultar el total de análisis de prospectiva finalizadas con empresas y emprendedores, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind34" name="txtfecha_inicio_ind34" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind34">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind34" name="txtfecha_fin_ind34" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind34">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarAnalisisEmpresasEmprendedoresFinalizadas_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind34" name="txt_total_ind34" value="" disabled>
                                  <label for="txt_total_ind34" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                    <div class="col s12 m6 l6">
                      <ul class="collapsible">
                        <li id="indicador35">
                          <div class="collapsible-header"><i class="material-icons">autorenew</i>Reestructuración y diseño de planta finalizadas con empresas y emprendedores.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de reestructuración y diseño de planta finalizadas con empresas y emprendedores.
                                <br>
                                Para consultar el total de reestructuración y diseño de planta finalizadas con empresas y emprendedores, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind35" name="txtfecha_inicio_ind35" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind35">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind35" name="txtfecha_fin_ind35" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind35">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarReestructuracionEmpresasEmprendedoresFinalizadas_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind35" name="txt_total_ind35" value="" disabled>
                                  <label for="txt_total_ind35" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador36">
                          <div class="collapsible-header"><i class="material-icons">autorenew</i>Estrategias de creación y posicionamiento de marca finalizadas con empresas y emprendedores.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de estrategias de creación y posicionamiento de marca finalizadas con empresas y emprendedores.
                                <br>
                                Para consultar el total de estrategias de creación y posicionamiento de marca finalizadas con empresas y emprendedores, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind36" name="txtfecha_inicio_ind36" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind36">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind36" name="txtfecha_fin_ind36" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind36">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarEstrategiasPosicionamientoEmpresasEmprendedoresFinalizadas_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind36" name="txt_total_ind36" value="" disabled>
                                  <label for="txt_total_ind36" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador37">
                          <div class="collapsible-header"><i class="material-icons">autorenew</i>Acompañamiento y gestión en el desarrollo de productos de propiedad intelectual finalizadas con empresas y emprendedores.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de acompañamiento y gestión en el desarrollo de productos de propiedad intelectual finalizadas con empresas y emprendedores.
                                <br>
                                Para consultar el total de acompañamiento y gestión en el desarrollo de productos de propiedad intelectual finalizadas con empresas y emprendedores, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind37" name="txtfecha_inicio_ind37" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind37">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind37" name="txtfecha_fin_ind37" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind37">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarPropiedadIntelectualEmpresasEmprendedoresFinalizadas_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind37" name="txt_total_ind37" value="" disabled>
                                  <label for="txt_total_ind37" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador38">
                          <div class="collapsible-header"><i class="material-icons">autorenew</i>Formular proyectos I+D+i para convocatorias finalizadas con empresas y emprendedores.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de formulación de proyectos I+D+i para convocatorias finalizadas con empresas y emprendedores.
                                <br>
                                Para consultar el total de formulación de proyectos I+D+i para convocatorias finalizadas con empresas y emprendedores, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind38" name="txtfecha_inicio_ind38" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind38">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind38" name="txtfecha_fin_ind38" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind38">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarFormulacionProyectosEmpresasEmprendedoresFinalizadas_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind38" name="txt_total_ind38" value="" disabled>
                                  <label for="txt_total_ind38" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador39">
                          <div class="collapsible-header"><i class="material-icons">autorenew</i>Asesoría a empresa o emprendedor finalizadas con empresas y emprendedores.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de asesorías a empresa o emprendedor finalizadas con empresas y emprendedores.
                                <br>
                                Para consultar el total de asesorías a empresa o emprendedor finalizadas con empresas y emprendedores, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind39" name="txtfecha_inicio_ind39" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind39">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind39" name="txtfecha_fin_ind39" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind39">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarAsesoriaEmpresasEmprendedoresFinalizadas_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind39" name="txt_total_ind39" value="" disabled>
                                  <label for="txt_total_ind39" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div id="indicadores_edts" class="row">
                    <div class="col s12 m6 l6">
                      <ul class="collapsible">
                        <li id="indicador40">
                          <div class="collapsible-header"><i class="material-icons">hearing</i>Número de Eventos de Divulgación	Tecnológica (EDTs).</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar la cantidad de EDTs.
                                <br>
                                Para consultar el total de EDT's, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind40" name="txtfecha_inicio_ind40" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind40">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind40" name="txtfecha_fin_ind40" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind40">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarEdts_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind40" name="txt_total_ind40" value="" disabled>
                                  <label for="txt_total_ind40" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador41">
                          <div class="collapsible-header"><i class="material-icons">hearing</i>Número de total de personas atendidas en EDT's.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el número de personas atendidas en EDT's.
                                <br>
                                Para consultar el total de personas atendidas en EDT's, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind41" name="txtfecha_inicio_ind41" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind41">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind41" name="txtfecha_fin_ind41" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind41">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarTotalPersonasEnEdts_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind41" name="txt_total_ind41" value="" disabled>
                                  <label for="txt_total_ind41" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador42">
                          <div class="collapsible-header"><i class="material-icons">hearing</i>Número de total de personas SENA atendidas en EDT's.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el número de personas SENA atendidas en EDT's.
                                <br>
                                Para consultar el total de personas SENA atendidas en EDT's, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind42" name="txtfecha_inicio_ind42" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind42">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind42" name="txtfecha_fin_ind42" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind42">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarTotalPersonasSenaEnEdts_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind42" name="txt_total_ind42" value="" disabled>
                                  <label for="txt_total_ind42" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                    <div class="col s12 m6 l6">
                      <ul class="collapsible">
                        <li id="indicador43">
                          <div class="collapsible-header"><i class="material-icons">hearing</i>Número de total de empresarios/empleados atendidas en EDT's.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el número de empresarios/empleados atendidas en EDT's.
                                <br>
                                Para consultar el total de empresarios/empleados atendidas en EDT's, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind43" name="txtfecha_inicio_ind43" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind43">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind43" name="txtfecha_fin_ind43" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind43">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarTotalPersonasEmpleadosEnEdts_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind43" name="txt_total_ind43" value="" disabled>
                                  <label for="txt_total_ind43" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador44">
                          <div class="collapsible-header"><i class="material-icons">hearing</i>Número de total de público general atendido en EDT's.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el número de público general atendido en EDT's.
                                <br>
                                Para consultar el total de público general atendido en EDT's, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind44" name="txtfecha_inicio_ind44" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind44">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind44" name="txtfecha_fin_ind44" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind44">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarTotalPublicoGeneralEnEdts_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind44" name="txt_total_ind44" value="" disabled>
                                  <label for="txt_total_ind44" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div id="indicadores_talentos" class="row">
                    <div class="col s12 m6 l6">
                      <ul class="collapsible">
                        <li id="indicador45">
                          <div class="collapsible-header"><i class="material-icons">supervised_user_circle</i>Número de total de talentos.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el número de talentos, los cuales hayan iniciado o cerrado proyectos entre dos fechas.
                                <br>
                                Para consultar el total de talentos activos, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind45" name="txtfecha_inicio_ind45" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind45">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind45" name="txtfecha_fin_ind45" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind45">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarTotalTalentosEnProyecto_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind45" name="txt_total_ind45" value="" disabled>
                                  <label for="txt_total_ind45" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador46">
                          <div class="collapsible-header"><i class="material-icons">supervised_user_circle</i>Número de total talentos SENA (aprendices).</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el número de talentos de talentos SENA (aprendices), los cuales hayan inicio o cerrado proyectos entre dos fechas.
                                <br>
                                Para consultar el total de talentos SENA (aprendices), debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind46" name="txtfecha_inicio_ind46" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind46">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind46" name="txtfecha_fin_ind46" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind46">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarTotalTalentosSenaEnProyecto_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind46" name="txt_total_ind46" value="" disabled>
                                  <label for="txt_total_ind46" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                    <div class="col s12 m6 l6">
                      <ul class="collapsible">
                        <li id="indicador47">
                          <div class="collapsible-header"><i class="material-icons">supervised_user_circle</i>Número de total talentos mujeres SENA (aprendices).</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el número de talentos de talentos mujeres SENA (aprendices), los cuales hayan inicio o cerrado proyectos entre dos fechas.
                                <br>
                                Para consultar el total de talentos mujeres SENA (aprendices), debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind47" name="txtfecha_inicio_ind47" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind47">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind47" name="txtfecha_fin_ind47" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind47">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarTotalTalentosMujerSenaEnProyecto_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind47" name="txt_total_ind47" value="" disabled>
                                  <label for="txt_total_ind47" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li id="indicador48">
                          <div class="collapsible-header"><i class="material-icons">supervised_user_circle</i>Número de total talentos egresados SENA.</div>
                          <div class="collapsible-body">
                            <div class="row">
                              <p>
                                Aquí podrás consultar el número de talentos de talentos egresados SENA, los cuales hayan inicio o cerrado proyectos entre dos fechas.
                                <br>
                                Para consultar el total de talentos egresados SENA, debes seleccionar dos fechas válidas y luego presionar el botón de "<b>Consultar</b>".
                              </p>
                            </div>
                            <div class="row">
                              <div class="input-field col s12 m8 l8">
                                {{-- <br> --}}
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_inicio_ind48" name="txtfecha_inicio_ind48" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                                  <label for="txtfecha_inicio_ind48">Fecha Inicio</label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                  <input type="text" id="txtfecha_fin_ind48" name="txtfecha_fin_ind48" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  <label for="txtfecha_fin_ind48">Fecha Fin</label>
                                </div>
                                <div class="center">
                                  <button onclick="consultarTotalTalentosEgresadosSenaEnProyecto_total(1)" class="btn">Consultar</button>
                                </div>
                              </div>
                              <div class="input-field col s12 m4 l4">
                                <div class="input-field col s12 m12 l12">
                                  <input type="text" id="txt_total_ind48" name="txt_total_ind48" value="" disabled>
                                  <label for="txt_total_ind48" class="active">Total</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
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
    function generarExcelConTodosLosIndicadores(bandera) {
      let idnodo = 0;
      let fecha_inicio = $('#txtfecha_inicio_todos').val();
      let fecha_fin = $('#txtfecha_fin_todos').val();
      if (bandera == 1) {
        idnodo = $('#txtnodo_id').val();
      }
      if (idnodo === '') {
        Swal.fire('Error!', 'Seleccione un nodo', 'error');
      } else {
        if (fecha_inicio > fecha_fin) {
          Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
        } else {
          location.href = '/excel/export/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
        }
      }


    }
  </script>
@endpush
