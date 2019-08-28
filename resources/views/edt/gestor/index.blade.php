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
                    <span class="card-title center-align"> Edts de {{ auth()->user()->nombres }} {{ auth()->user()->apellidos }}</span>
                  </div>
                </div>
                <div class="col s12 m2 l2">
                  <div class="click-to-toggle show-on-large hide-on-med-and-down">
                    <a href="{{route('edt.create')}}" class="btn tooltipped btn-floating btn-large green" data-position="bottom" data-delay="50" data-tooltip="Nueva Edt">
                      <i class="material-icons">record_voice_over</i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="divider"></div>
              <div class="right material-icons">
                <a href="{{route('edt.excel.gestor', auth()->user()->gestor->id)}}">
                  <img class="btn btn-flat" src="https://img.icons8.com/color/48/000000/ms-excel.png">
                </a>
              </div>
              <table class="display responsive-table datatable-example" id="edtPorGestor_table" >
                <thead>
                  <th>Código de la Edt</th>
                  <th>Nombre</th>
                  <th>Gestor</th>
                  <th>Área de Conocimiento</th>
                  <th>Tipo de Edt</th>
                  <th>Empresas</th>
                  <th>Detalles</th>
                  <th>Editar</th>
                  <th>Entregables</th>
                </thead>

              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
        <a href="{{route('edt.create')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nueva Edt">
          <i class="material-icons">record_voice_over</i>
        </a>
      </div>
    </div>
  </main>
  @include('edt.modals')
@endsection
