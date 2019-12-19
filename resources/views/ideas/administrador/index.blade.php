@extends('layouts.app')
@section('meta-title', 'Ideas')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <div class="row">
              <div class="col s8 m8 l10">
                  <h5 class="left-align">
                      <i class="material-icons left">
                          lightbulb
                      </i>
                      Ideas de Proyecto
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Ideas de Proyecto</li>
                  </ol>
              </div>
          </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="center-align">
                      <span class="card-title">Ideas de Tecnoparque</span>
                      <div class="divider"></div>
                    </div>
                  </div>
                </div>
                <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                  <li class="tab col s3"><a href="#ideasProyecto" class="active">Ideas de Proyecto (emprendedor)</a></li>
                  <li class="tab col s3"><a href="#ideasProyectoEmpresa" onclick="ideasEmpresasGruposDeInvestigacionPorNodo();">Ideas de Proyecto (empresa/grupo de investigación)</a></li>
                  <div class="indicator" style="right: 580.5px; left: 0px;"></div>
                </ul>
                <div class="input-fiel col s12 m12 l12">
                  <label class="active" for="selectnodo">Nodo <span class="red-text">*</span></label>
                  <select class="initialized" id="txtnodo" name="txtnodo" style="width: 100%" tabindex="-1" onchange="consultarIdeasPorNodo()">
                    <option value="">Seleccione nodo</option>
                    @foreach($nodos as $nodo)
                      <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="divider"></div>
                <div id="ideasProyecto">
                    <table id="ideasEmprendedoresPorNodo_table" class="dataTable js-state browser-default" style="width: 100%">
                    <thead>
                      <tr>
                        <th width="10%">Código de la Idea</th>
                        <th width="15%">Fecha de Registro</th>
                        <th width="20%">Persona</th>
                        <th>Correo</th>
                        <th>Contacto</th>
                        <th>Nombre de la Idea</th>
                        <th>Estado</th>
                        <th>Detalles</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
                <div id="ideasProyectoEmpresa">
                  <table id="ideasEmpresasGIPorNodo_table" class="dataTable js-state browser-default" style="width: 100%">
                    <thead>
                      <tr>
                        <th>Código de la Idea</th>
                        <th>Fecha de Registro</th>
                        <th>Nit</th>
                        <th>Razón Social</th>
                        <th>Nombre de la Idea</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="modal1" class="modal modal-fixed-footer">
          <div class="modal-content">
            <center><h4 id="titulo" class="center-aling"></h4></center>
            <div class="divider"></div>
            <div id="detalle_idea"></div>
          </div>
          <div class="modal-footer  white-text">
            <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
          </div>
        </div>
      </div>
      <div class="fixed-action-btn horizontal click-to-toggle show-on-medium-and-down hide-on-med-and-up">
        <a class="btn-floating btn-large red">
          <i class="material-icons">menu</i>
        </a>
        <ul>
          <li>
            <a class="btn-floating green" href="{{ route('ideas.index') }}" target="_blank">
              <i class="material-icons">lightbulb</i>
            </a>
          </li>
          {{-- <li>
            <a class="btn-floating green" href="{{route('idea.egi')}}">
              <i class="material-icons">business</i>
            </a>
          </li> --}}
        </ul>
      </div>
    </div>
  </div>
</main>
<!-- <div id="modal1" class="modal">
  <div class="modal-content">
    <h4>Modal Header</h4>
    <p>A bunch of text</p>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>
  </div>
</div> -->
<div id="modal1" class="modal">
  <div class="modal-content">
    <center><h4 id="titulo" class="center-aling"></h4></center>
    <div class="divider"></div>
    <div id="detalle_idea"></div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
  </div>
</div>
@endsection
