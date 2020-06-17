@extends('layouts.app')
@section('meta-title', 'Ideas')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <div class="row">
              <div class="col s12 m8 l9">
                  <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                      <i class="material-icons left">
                          lightbulb
                      </i>
                      Ideas de Proyecto
                  </h5>
              </div>
              <div class="col s12 m4 l3 rigth-align show-on-large hide-on-med-and-down">
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
                    <span class="card-title hand-of-Sean-fonts orange-text text-darken-3">Ideas de {{config('app.name')}}</span>
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
                    <table id="ideasEmprendedoresPorNodo_table" class="display responsive-table datatable-example dataTable" style="width: 100%">
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
                  <table id="ideasEmpresasGIPorNodo_table" class="display responsive-table datatable-example" style="width: 100%">
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

    </div>
  </div>
</main>
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
