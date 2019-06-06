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
                  <div class="col s12 m12 l12">
                    <div class="center-align">
                      <span class="card-title center-align">Ideas de Tecnoparque nodo "FALTA"</span>
                    </div>
                  </div>
                </div>
                <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                  <li class="tab col s3"><a href="#ideasProyecto" class="active">Ideas de Proyecto (emprendedor)</a></li>
                  <li class="tab col s3"><a href="#ideasProyectoEmpresa">Ideas de Proyecto (empresa/grupo de investigación)</a></li>
                  <li class="tab col s3"><a href="#ideaUnica">Buscar Idea</a></li>
                  <div class="indicator" style="right: 580.5px; left: 0px;"></div>
                </ul>
                <div class="divider"></div>
                <div id="ideaUnica">
                  <div class="row">
                    <div class="input-field col s2 m2 l2">
                      <select name="txtfiltro" id="txtfiltro">
                        <option value="0">Todo</option>
                        <option value="1">Nombre de Idea</option>
                        <option value="2">Persona</option>
                        <option value="3">Contacto</option>
                        <option value="4">Correo</option>
                      </select>
                    </div>
                    <div class="input-field col s10 m10 l10">
                      <input type="text" name="txtparametros" id="txtparametros">
                      <label for="parametros">Buscar Idea</label>
                    </div>
                  </div>
                  <table id="tbl_ideaunica" class="display responsive-table datatable-example dataTable">
                    <thead>
                      <th>Consecutivo de la Idea</th>
                      <th>Fecha de Registro</th>
                      <th>Persona</th>
                      <th>Correo</th>
                      <th>Contacto</th>
                      <th>Nombre de la Idea</th>
                      <th>Primera Sesion</th>
                      <th>Segunda Sesion</th>
                      <th>Fecha del Comité</th>
                      <th>Hora</th>
                      <th>¿Admitido?</th>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
                <div id="ideasProyecto">
                  <table id="tblideas" class="display responsive-table datatable-example">
                    <thead>
                      <tr>
                        <th>Consecutivo de la Idea</th>
                        <th>Fecha de Registro</th>
                        <th>Persona</th>
                        <th>Correo</th>
                        <th>Contacto</th>
                        <th>Nombre de la Idea</th>
                        <th>Estado</th>
                        <!-- <th>Primera Sesion</th> -->
                        <!-- <th>Segunda Sesion</th> -->
                        <th>Detalles</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
                <div id="ideasProyectoEmpresa">
                  <table id="tblideasempresas" class="display responsive-table datatable-example">
                    <thead>
                      <tr>
                        <th>Consecutivo de la Idea</th>
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
@endsection
