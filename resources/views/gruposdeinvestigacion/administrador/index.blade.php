@extends('layouts.app')
@section('meta-title', 'Grupos de Investigación')
@section('meta-content', 'Grupos de Investigación')
@section('meta-keywords', 'Grupos de Investigación')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>Empresas</h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="center-align">
                      <span class="card-title center-align">Grupos de Investigación de Tecnoparque</span>
                    </div>
                  </div>
                </div>
                <center>
                </center>
                <div class="divider"></div>
                <table style="width: 100%" id="grupoDeInvestigacionTecnoparque_tableNoGestor" class="display responsive-table datatable-example dataTable">
                  <thead>
                    <tr>
                      <th>Código del Grupo de Investigación</th>
                      <th>Nombre del Grupo de Investigación</th>
                      <th>Ciudad</th>
                      <th>Tipo de Grupo de Investigación</th>
                      <th>Institución</th>
                      <th>Clasificación de Colciencias</th>
                      <th>Detalles</th>
                      {{-- <th>Editar</th> --}}
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
<div id="detalleDeUnGrupoDeInvestigacion" class="modal">
  <div class="modal-content">
    <center><h4 id="modalDetalleDeUnGrupoDeInvestigacion_titulo" class="center-aling"></h4></center>
    <div class="divider"></div>
    <div id="modalDetalleDeUnGrupoDeInvestigacion_detalle_empresa"></div>
  </div>
  <div class="modal-footer white-text">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat">Cerrar</a>
  </div>
</div>
@endsection
