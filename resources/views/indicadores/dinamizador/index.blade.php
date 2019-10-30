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
                  <div class="row">
                    <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                      <li class="tab col s3"><a class="active" href="#indicadores_proyectos">Proyectos</a></li>
                      <li class="tab col s3"><a class="" href="#indicadores_articulaciones">Articulaciones</a></li>
                      {{-- <li class="tab col s3"><a class="" href="#proyectos_ipe">Proyectos en Inicio, Planeación o Ejecución</a></li> --}}
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
                                  <button onclick="consultarProyectosInscritos_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarProyectosEnEjecucion_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarPFFfinalizados_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarProyectosInscritosAprendizInstructor_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarProyectosEnEjecucionConSena_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarProyectosPFFFinalizadosAprendizInstructor_total(0)" class="btn">Consultar</button>
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
                                Aquí podrás consultar el costo total de los PFF finalizados.
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
                                  <button onclick="consultarCostosPFFfinalizadosSena_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarProyectosInscritosEmpresas_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarProyectosEnEjecucionConEmpresas_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarProyectosPFFFinalizadosEmpresas_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarCostosPFFfinalizadosEmpresas_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarTalentoEnAsocioProyectosConEmpresa_total(0)" class="btn">Consultar</button>
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
                      </ul>
                    </div>
                    <div class="col s12 m6 l6">
                      <ul class="collapsible">
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
                                  <button onclick="consultarProyectosInscritosEmprendedoresInvetoresOtros_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarProyectosEnEjecucionConEmprendedoresInventoresOtros_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarPFFFinalizadosEmprendedoresInvetoresOtros_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarCostosPFFfinalizadosEmprendedoresOtros_total(0)" class="btn">Consultar</button>
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
                          <div class="collapsible-header"><i class="material-icons">library_books</i>Número total de PFF finalizados.</div>
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
                                  <button onclick="consultarPMVfinalizados_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarProyectosPMVFinalizadosAprendizInstructor_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarCostosPMVfinalizadosSena_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarProyectosPMVFinalizadosEmpresas_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarCostosPMVfinalizadosEmpresas_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarPMVFinalizadosEmprendedoresInvetoresOtros_total(0)" class="btn">Consultar</button>
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
                                  <button onclick="consultarCostosPMVfinalizadosEmprendedoresOtros_total(0)" class="btn">Consultar</button>
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
                      </ul>
                    </div>
                  </div>
                  <div id="indicadores_articulaciones" class="row">
                    <p>Something</p>
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

@endpush
