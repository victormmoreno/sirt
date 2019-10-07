@extends('layouts.app')
@section('meta-title', 'Ideas')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5><i class="left material-icons">lightbulb</i>Ideas de Proyecto</h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="center-align">
                      <span class="card-title center-align">Ideas de Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }}</span>
                    </div>
                  </div>
                </div>
                <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                  <li class="tab col s3"><a href="#ideasProyecto" class="active">Ideas de Proyecto</a></li>
                  <li class="tab col s3"><a href="#ideaUnica">Buscar Ideas</a></li>
                  <div class="indicator" style="right: 580.5px; left: 0px;"></div>
                </ul>
                <div class="divider"></div>
                <div id="ideaUnica">
                  <table id="tbl_TodasLasIdeasDeProyecto" class="display responsive-table datatable-example dataTable" style="width: 100%">
                    <thead>
                      <th>Código de la Idea</th>
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
                  <table id="ideasEmprendedoresPorNodo_table" class="display responsive-table datatable-example" style="width: 100%">
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
