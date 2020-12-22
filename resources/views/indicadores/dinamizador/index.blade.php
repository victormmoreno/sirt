@extends('layouts.app')
@section('meta-title', 'Indicadores')
@section('content')
  @php
  $now = Carbon\Carbon::now();
  $yearNow = $now->year;
  $monthNow = $now->month;
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
                          info_outline
                      </i>
                      Indicadores
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Indicadores</li>
                  </ol>
              </div>
          </div>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <div class="center-align">
                        <span class="card-title center-align">Indicadores</span>
                      </div>
                    </div>
                  </div>
                  <div class="row card-panel teal lighten-5">
                    <h6>Para consultar TODOS los indicadores, debes seleccionar un rango de fechas y luego presionar el botón de descarga.</h6>
                    <div class="input-field col s12 m5 l5">
                      <input type="text" id="txtfecha_inicio_todos" name="txtfecha_inicio_todos" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                      <label for="txtfecha_inicio_todos">Fecha Inicio</label>
                    </div>
                    <div class="input-field col s12 m5 l5">
                      <input type="text" id="txtfecha_fin_todos" name="txtfecha_fin_todos" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                      <label for="txtfecha_fin_todos">Fecha Fin</label>
                    </div>
                    <div class="center input-field col s12 m2 l2">
                      <a onclick="generarExcelConTodosLosIndicadores(0);" class="btn"><i class="material-icons">file_download</i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
@push('script')
  <script>
    function generarExcelConTodosLosIndicadores(bandera) {
      let idnodo = 0;
      let fecha_inicio = $('#txtfecha_inicio_todos').val();
      let fecha_fin = $('#txtfecha_fin_todos').val();
      if (bandera == 1) {
        idnodo = $('#txtnodo_id').val();
      }

      if (idnodo === '') {
        Swal.fire('Error!', 'Seleccione un nodo', 'error');
      } else {
        if (fecha_inicio > fecha_fin) {
          Swal.fire('Error!', 'Seleccione fechas válidas', 'error');
        } else {
          location.href = '/excel/export/'+idnodo+'/'+fecha_inicio+'/'+fecha_fin;
        }
      }


    }
  </script>
@endpush
