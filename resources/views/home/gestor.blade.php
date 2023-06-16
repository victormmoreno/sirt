@extends('layouts.app')
@section('meta-title', 'Inicio')
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="middle-content">
            <div class="row">
                <div class="col s12 m5 l5">
                    <div class="card stats-card">
                        <div class="card-content">
                            <span class="stats-counter">
                                <small>Aquí se visualiza la cantidad de proyectos inscritos por mes en el año
                                    actual.</small>
                            </span>
                            <div id="graficoSeguimientoInscritosPorMes_column" class="green lighten-3"
                                style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                        </div>
                        <div class="progress stats-card-progress bg-secondary">
                            <div class="determinate"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="card card-transparent">
                        <div class="card-content">
                            <div class="center-align">
                                <p class="card-title aling-center">Bienvenido <span class="secondary-title"> Sistema
                                        Nacional de la Red de Tecnoparques Colombia</span>
                                </p>
                            </div>
                            <div class="row">
                                <div class="col s12 m12 l10 offset-l1">
                                    <img class="materialboxed responsive-img"
                                        src="{{ asset('img/logo-tecnoparque-green.svg') }}" alt="sena | Tecnoparque">
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
        $(document).ready(function() {
            consultarProyectosInscritosPorMes({{ auth()->user()->gestor->id }});
        });

        function consultarProyectosInscritosPorMes(gestor_id) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                url: host_url + '/seguimiento/seguimientoInscritosPorMesExperto/' + gestor_id,
                success: function(data) {
                    graficoSeguimientoPorMes(data, graficosSeguimiento.inscritos_mes);
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
                },
            })
        }
    </script>
@endpush
