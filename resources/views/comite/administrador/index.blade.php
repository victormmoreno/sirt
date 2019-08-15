@extends('layouts.app')
@section('meta-title', 'CSIBT')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5><i class="left material-icons left">gavel</i>Comité de Selección de Ideas</h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <center>
                  <span class="card-title center-align">CSIBT de Tecnoparque</span>
                </center>
                <div class="input-fiel col s12 m12 l12">
                  <i class="material-icons">domain</i>
                  <label for="txtnodo">Nodo</label>
                  <select class="initialized" id="txtnodo" name="txtnodo" style="width: 100%" tabindex="-1" onchange="consultarCsibtPorNodo()">
                    <option value="">Seleccione Nodo * </option>
                    @foreach($nodos as $nodo)
                      <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="divider"></div>
                <table class="display responsive-table datatable-example dataTable" id="comitesDelNodoAdministrador_table">
                  <thead>
                    <tr>
                      <th>Código del Comité</th>
                      <th>Fecha</th>
                      <th>Observaciones</th>
                      <th>Ideas de Proyecto</th>
                      <th>Evidencias</th>
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
    </div>
  </div>
</main>
<div id="ideaProyecto" class="modal modal-fixed-footer">
  <div class="modal-content">
    <center><h4 id="titulo" class="center-aling"></h4></center>
    <div class="divider"></div>
    <div id="detalle_idea"></div>
  </div>
  <div class="modal-footer  white-text">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
  </div>
</div>
<div id="modalIdeasComite" class="modal modal-fixed-footer">
  <div class="modal-content">
    <center><h4 id="fechaComiteModal" class="center-aling"></h4></center>
    <div class="divider"></div>
    <div>
      <table class="striped">
        <thead>
          <tr>
            <th>Idea de Proyecto</th>
            <th>Hora</th>
            <th>Asistencia</th>
            <th>Observaciones</th>
            <th>Admitido</th>
            <th>Editar Idea</th>
            <th>Detalles de la Idea</th>
          </tr>
        </thead>
        <tbody id="ideasProyectoDeUnComite">

        </tbody>
      </table>
    </div>
  </div>
  <div class="modal-footer  white-text">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
  </div>
</div>
@endsection
