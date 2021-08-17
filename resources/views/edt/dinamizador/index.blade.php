@extends('layouts.app')
@section('meta-title', 'Eventos de Divulgación Tecnológica')
@section('meta-content', 'Eventos de Divulgación Tecnológica')
@section('meta-keywords', 'Eventos de Divulgación Tecnológica')
@section('content')
  @php
    $year = Carbon\Carbon::now(); $year = $year->isoFormat('YYYY');
  @endphp
  <link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <div class="row">
              <div class="col s8 m8 l10">
                  <h5 class="left-align">
                      <i class="material-icons left">
                          hearing
                      </i>
                      Edt
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Edt</li>
                  </ol>
              </div>
          </div>
          <div class="card stats-card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="center-align">
                    <span class="card-title center-align"> Edts de Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }}</span>
                  </div>
                </div>
              </div>
              <div class="divider"></div>
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="input-field col s12 m12 l12">
                    <select class="js-states"  tabindex="-1" style="width: 100%" id="txtanho_edts_Nodo" name="txtanho_edts_Nodo" onchange="datatableEdtsPorNodo(0);">
                      @for ($i=2016; $i <= $year; $i++)
                        <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                      @endfor
                    </select>
                    <label for="txtanho_edts_Nodo">Seleccione el Año</label>
                  </div>
                </div>
              </div>
              <table class="display responsive-table datatable-example" style="width: 100%" id="edtPorNodo_table" >
                <thead>
                  <th>Código de la Edt</th>
                  <th>Nombre</th>
                  <th>Experto</th>
                  <th>Área de Conocimiento</th>
                  <th>Tipo de Edt</th>
                  <th>Fecha de Inicio</th>
                  <th>Estado</th>
                  <th>Empresas</th>
                  <th>Detalles</th>
                  <th>Entregables</th>
                  <th>Editar</th>
                  <th>Eliminar</th>
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
