@extends('layouts.app')
@section('meta-title', 'Empresas')
@section('meta-content', 'Empresas')
@section('meta-keywords', 'Empresas')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5><i class="left material-icons">business_center</i>Empresas</h5>
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
                </div>
                <center>
                </center>
                <div class="divider"></div>
                <table style="width: 100%" id="empresasDeTecnoparque_tableNoGestor" class="display responsive-table datatable-example dataTable">
                  <thead>
                    <tr>
                      <th>Nit</th>
                      <th>Nombre de la Empresa</th>
                      <th>Sector de la Empresa</th>
                      <th>Ciudad - Departamento</th>
                      <th>Dirección</th>
                      <th>Detalles</th>
                      {{-- <th>Inhabilitar</th> --}}
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
{{-- <div id="detalleDeUnaEmpresaTecnoparque" class="modal">
  <div class="modal-content">
    <center><h4 id="modalDetalleDeUnaEmpresaTecnoparque_titulo" class="center-aling"></h4></center>
    <div class="divider"></div>
    <div id="modalDetalleDeUnaEmpresaTecnoparque_detalle_empresa"></div>
  </div>
  <div class="modal-footer white-text">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat">Cerrar</a>
  </div>
</div> --}}
@include('empresa.modals')
@endsection
