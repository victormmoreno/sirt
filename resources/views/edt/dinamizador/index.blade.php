@extends('layouts.app')
@section('meta-title', 'Eventos de Divulgación Tecnológica')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5><i class="left material-icons">record_voice_over</i>Edt</h5>
          <div class="card stats-card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m10 l10">
                  <div class="center-align">
                    <span class="card-title center-align"> Edts de Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }}</span>
                  </div>
                </div>
              </div>
              <div class="divider"></div>
              <table class="display responsive-table datatable-example" id="edtPorNodo_table" >
                <thead>
                  <th>Código de la Edt</th>
                  <th>Nombre</th>
                  <th>Gestor</th>
                  <th>Área de Conocimiento</th>
                  <th>Tipo de Edt</th>
                  <th>Empresas</th>
                  <th>Detalles</th>
                  <th>Entregables</th>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  @include('edt.modals')
@endsection
