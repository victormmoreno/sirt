@extends('layouts.app')
@section('meta-title', 'Gráficos de Articulaciones')
@section('content')
  @php
  $yearNow = Carbon\Carbon::now()->isoFormat('YYYY')
  @endphp
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5>
            <a class="footer-text left-align" href="{{route('grafico')}}">
              <i class="left material-icons">arrow_back</i>
            </a> Gráficos
          </h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="input-field col s12 m4 l4">
                      <select id="txtnodo_id" name="txtnodo_id" style="width: 100%" tabindex="-1" onchange="getGestorYLineasDeUnNodo(this.value)">
                        <option value="">Seleccione el Nodo</option>
                        @foreach($nodos as $id => $nombre)
                          <option value="{{$id}}">{{$nombre}}</option>
                        @endforeach
                      </select>
                      <label for="txtnodo_id">Seleccione un nodo</label>
                    </div>
                    <div class="col s12 m8 l8">
                      <div class="center-align">
                        <span class="card-title center-align">Gráficos de Articulaciones</span>
                      </div>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <ul class="collapsible">
                    <li>
                      <div class="collapsible-header"><i class="material-icons">record_voice_over</i>Edt's por fechas</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="input-field col s12 m4 l4">
                            <div class="input-field col s12 m6 l6">
                              <input type="text" id="txtfecha_inicio_edtGrafico1" name="txtfecha_inicio_edtGrafico1" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                              <label for="txtfecha_inicio_edtGrafico1">Fecha Inicio</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                              <input type="text" id="txtfecha_fin_edtGrafico1" name="txtfecha_fin_edtGrafico1" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                              <label for="txtfecha_fin_edtGrafico1">Fecha Fin</label>
                            </div>
                            <div class="center col s12 m12 l12">
                              <button onclick="consultarEdtsPorNodoGestorYFecha_stacked(1);" class="btn">Consultar</button>
                            </div>
                          </div>
                          <div class="col s12 m8 l8">
                            <div id="graficosEdtsPorGestorNodoYFecha_stacked" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">record_voice_over</i>Edt's por gestor y fecha</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="col s12 m4 l4">
                            <div class="input-field col s12 m12 l12">
                              <select id="txtgestor_id_edtGrafico2" name="txtgestor_id_edtGrafico2" style="width: 100%" tabindex="-1">
                                <option value="">Seleccione el Gestor</option>

                              </select>
                              <label for="txtgestor_id_edtGrafico2">Gestor</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                              <input type="text" id="txtfecha_inicio_edtGrafico2" name="txtfecha_inicio_edtGrafico2" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                              <label for="txtfecha_inicio_edtGrafico2">Fecha Inicio</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                              <input type="text" id="txtfecha_fin_edtGrafico2" name="txtfecha_fin_edtGrafico2" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                              <label for="txtfecha_fin_edtGrafico2">Fecha Fin</label>
                            </div>
                            <div class="center col s12 m12 l12">
                              <button onclick="consultarEdtsPorGestorYFecha_stacked(1)" class="btn">Consultar</button>
                            </div>
                          </div>
                          <div class="col s12 m8 l8">
                            <div id="graficosEdtsPorGestorYFecha_stacked" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                              <div class="row card-panel">
                                <h5 class="center">Para consultar las edts por gestor, se debe seleccionar un gestor y fechas válidas, luego presionar el botón consultar</h5>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">record_voice_over</i>Edt's por línea y fecha</div>
                      <div class="collapsible-body">
                        <div class="row">
                          <div class="col s12 m4 l4">
                            <div class="input-field col s12 m12 l12">
                              <select id="txtlinea_id_edtGrafico3" name="txtlinea_id_edtGrafico3" style="width: 100%">
                                <option value="">Seleccione la Línea Tecnológica</option>

                              </select>
                            </div>
                            <div class="input-field col s12 m6 l6">
                              <input type="text" id="txtfecha_inicio_GraficoEdt3" name="txtfecha_inicio_GraficoEdt3" class="datepicker picker__input" value="{{Carbon\Carbon::create($yearNow, 1, 1)->toDateString() }}">
                              <label for="txtfecha_inicio_GraficoEdt3">Fecha Inicio</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                              <input type="text" id="txtfecha_fin_GraficoEdt3" name="txtfecha_fin_GraficoEdt3" class="datepicker picker__input" value="{{Carbon\Carbon::now()->toDateString()}}">
                              <label for="txtfecha_fin_GraficoEdt3">Fecha Fin</label>
                            </div>
                            <div class="center">
                              <button onclick="consultarEdtsPorLineaYFecha_stacked(1)" class="btn">Consultar</button>
                            </div>
                          </div>
                          <div class="col s12 m8 l8">
                            <div id="graficoEdtsPorLineaYFecha_stacked" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                              <div class="row card-panel">
                                <h5 class="center">Para consultar las cantidad de edts por línea, se debe seleccionar una línea tecnológica y fechas válidas, luego presionar el botón CONSULTAR</h5>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="collapsible-header"><i class="material-icons">record_voice_over</i>Edt's totales por año</div>
                      <div class="collapsible-body">
                        <div class="row valign-wrapper">
                          <div class="input-field col s12 m4 l4">
                            <select style="width: 100%" name="txtanho_GraficoEdt4" id="txtanho_GraficoEdt4" onchange="consultarEdtsDelNodoPorAnho_variablepie(1)">
                              @for ($i=2016; $i <= $yearNow; $i++)
                                <option value="{{ $i }}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{ $i }}</option>
                              @endfor
                            </select>
                            <label for="txtanho_GraficoEdt4">Seleccione el Año</label>
                          </div>
                          <div class="col s12 m8 l8">
                            <div id="graficoEdtsPorNodoYAnho_variablepie" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
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
    // $(document).ready(function(){});
    function getGestorYLineasDeUnNodo(id) {
      if (id == '') {
        Swal.fire('Advertencia!', 'Seleccione un nodo válido!', 'warning');
      } else {
        $.ajax({
          dataType: 'json',
          type: 'get',
          url: '/grafico/consultarGestoresYLineasDeUnNodo/'+id,
          success: function (data) {
            $('#txtgestor_id_edtGrafico2').empty();
            $('#txtgestor_id_edtGrafico2').append('<option value="">Seleccione el Gestor</option>')
            $.each(data.gestores, function(i, e) {
              // console.log(e.nombres_gestor);
              $('#txtgestor_id_edtGrafico2').append('<option value="'+e.id+'">'+e.nombres_gestor+'</option>');
            })

            $('#txtlinea_id_edtGrafico3').empty();
            $('#txtlinea_id_edtGrafico3').append('<option value="">Seleccione la Línea Tecnológica</option>')
            $.each(data.lineas, function(i, e) {
              // console.log(e.nombres_gestor);
              $('#txtlinea_id_edtGrafico3').append('<option value="'+e.id+'">'+e.nombre+'</option>');
            })
            $('#txtgestor_id_edtGrafico2').material_select();
            $('#txtlinea_id_edtGrafico3').material_select();
          },
          error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
          },
        });
      }
    }
  </script>
@endpush
