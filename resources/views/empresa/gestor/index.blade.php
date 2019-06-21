@extends('layouts.app')
@section('meta-title', 'Empresas')
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
                  <div class="col s12 m10 l10">
                    <div class="center-align">
                      <span class="card-title center-align">Empresas de Tecnoparque</span>
                    </div>
                  </div>
                  <div class="col s12 m2 l2">
                    <div class="click-to-toggle show-on-large hide-on-med-and-down">
                      <a href="{{route('empresa.create')}}" class="btn btn-floating btn-large tooltipped green" data-position="bottom" data-delay="50" data-tooltip="Nueva Empresa">
                        <i class="material-icons">exposure_plus_1</i>
                      </a>
                    </div>
                  </div>
                </div>
                <center>
                </center>
                <div class="divider"></div>
                <table style="width: 100%" id="empresasDeTecnoparque_table" class="display responsive-table datatable-example dataTable">
                  <thead>
                    <tr>
                      <th>Nit</th>
                      <th>Nombre de la Empresa</th>
                      <th>Sector de la Empresa</th>
                      <th>Ciudad - Departamento</th>
                      <th>Dirección</th>
                      <th>Detalles</th>
                      <th>Editar</th>
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
      <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
        <a href="{{route('empresa.create')}}" class="btn btn-floating btn-large tooltipped green" data-position="left" data-delay="50" data-tooltip="Nueva Empresa">
          <i class="material-icons">exposure_plus_1</i>
        </a>
      </div>
    </div>
  </div>
</main>
<div id="detalleDeUnaEmpresaTecnoparque" class="modal">
  <div class="modal-content">
    <center><h4 id="modalDetalleDeUnaEmpresaTecnoparque_titulo" class="center-aling"></h4></center>
    <div class="divider"></div>
    <div id="modalDetalleDeUnaEmpresaTecnoparque_detalle_empresa"></div>
  </div>
  <div class="modal-footer white-text">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat">Cerrar</a>
  </div>
</div>
@endsection
