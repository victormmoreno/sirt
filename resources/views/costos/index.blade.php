@extends('layouts.app')
@section('meta-title', 'Costos')
@section('meta-content', 'Costos')
@section('meta-keywords', 'Costos')
@section('content')
    @php
    $yearNow = Carbon\Carbon::now()->isoFormat('YYYY');
    @endphp
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
            <div class="row">
                <div class="col s8 m8 l10">
                    <h5 class="left-align">
                        <i class="material-icons left">
                            attach_money
                        </i>
                        Costos
                    </h5>
                </div>
                <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li class="active">Costos</li>
                    </ol>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                <div class="row">
                    <div class="col s12 m12 l12">
                        <ul class="collapsible">
                            @switch(session()->get('login_role'))
                                @case(App\User::IsDinamizador())
                                    @include('costos.project')
                                    @break
                                @case(App\User::IsGestor())
                                    @include('costos.project')
                                    @break
                                @case(App\User::IsArticulador())

                                @break
                                @default
                            @endswitch

                        </ul>
                    <br>
                    </div>
                    <div id="actividades">
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
        $( document ).ready(function() {
            consultarProyectosDelGestor_costos('{{$yearNow}}');
        });
        function consultarProyectosDelGestor_costos (value) {
            let anho = value;
            $('#txtactividad_id').empty();
            $('#txtactividad_id').append('<option value="">Seleccione un proyecto</option>');
            consultarProyectos(anho);
            $('#txtactividad_id').select2();
        }

        function consultarProyectos(anho) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                url: host_url + '/proyecto/consultarProyectos_costos/' + anho
            }).done(function(response) {
                $.each(response.proyectos, function(i, e) {
                    $('#txtactividad_id').append('<option  value="' + e.id + '">' + e.codigo_proyecto + ' - ' + e.nombre + '</option>');
                })
            });
        }

        function consultarArticulaciones(anho) {
            $.ajax({
                dataType: 'json',
                type: 'get',
                url: host_url + '/articulacion/consultarArticulaciones_costos/' + anho
            }).done(function(response) {
                $.each(response.articulaciones, function(i, e) {
                $('#txtactividad_id').append('<option  value="' + e.id + '">' + e.codigo_articulacion + ' - ' + e.nombre + '</option>');
                })
            });
        }
    </script>
@endpush
