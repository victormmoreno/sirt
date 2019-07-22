@extends('layouts.app')
@section('meta-title', 'Ideas')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5><i class="material-icons">lightbulb</i>Ideas de Proyecto</h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="row">
                  <div class="col s12 m8 l8">
                    <div class="center-align">
                      <span class="card-title center-align">Ideas de Tecnoparque nodo {{ \NodoHelper::returnNodoUsuario() }}</span>
                    </div>
                  </div>
                  <div class="col s12 m2 l2">
                    <div class="click-to-toggle show-on-large hide-on-med-and-down">
                      <a href="{{ route('ideas.index') }}" target="_blank" class="btn btn-floating btn-large tooltipped green" data-position="button" data-delay="50" data-tooltip="Nueva Idea de Proyecto (Emprendedor)">
                        <i class="material-icons">lightbulb</i>
                      </a>
                    </div>
                  </div>
                  <div class="col s12 m2 l2">
                    <div class="click-to-toggle show-on-large hide-on-med-and-down">
                      <a href="{{route('idea.egi')}}" class="btn btn-floating btn-large tooltipped green" data-position="button" data-delay="50" data-tooltip="Nueva Idea de Proyecto (Empresa/Grupo de Investigación)">
                        <i class="material-icons">business</i>
                      </a>
                    </div>
                  </div>
                </div>
                <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                  <li class="tab col s3"><a href="#ideasProyecto" class="active">Ideas de Proyecto (emprendedor)</a></li>
                  <li class="tab col s3"><a href="#ideasProyectoEmpresa" onclick="secondDataTable();">Ideas de Proyecto (empresa/grupo de investigación)</a></li>
                  <div class="indicator" style="right: 580.5px; left: 0px;"></div>
                </ul>
                <div class="divider"></div>
                <div id="ideasProyecto">
                  <table id="ideas_emprendedores_table" class="dataTable js-state browser-default" style="width: 100%">
                    <thead>
                      <tr>
                        <th>Código de la Idea</th>
                        <th>Fecha de Registro</th>
                        <th>Persona</th>
                        <th>Correo</th>
                        <th>Contacto</th>
                        <th>Nombre de la Idea</th>
                        <th>Estado</th>
                        <th>Detalles</th>
                        <th>Editar</th>
                        <th>Inhabilitar</th>
                        <th>No aplica</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
                <div id="ideasProyectoEmpresa">
                  <table id="tblideasempresas" class="dataTable js-state browser-default" style="width: 100%">
                    <thead>
                      <tr>
                        <th>Código de la Idea</th>
                        <th>Fecha de Registro</th>
                        <th>Nit/Código del Grupo de Investigación</th>
                        <th>Razón Social/Nombre del Grupo</th>
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
          <li>
            <a class="btn-floating green" href="{{route('idea.egi')}}">
              <i class="material-icons">business</i>
            </a>
          </li>
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
