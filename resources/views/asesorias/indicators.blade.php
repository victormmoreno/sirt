@extends('layouts.app')
@section('meta-title', 'Asesoría y Uso')
@section('content')
@php
    $now = Carbon\Carbon::now();
    $yearNow = $now->year;
    $monthNow = $now->month;
    $can_read_all = true;
    if (Str::contains(session()->get('login_role'), [App\User::IsExperto(), App\User::IsArticulador(), App\User::IsApoyoTecnico()])) {
        $can_read_all = false;
    }
@endphp
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <a class="footer-text left-align" href="{{route('asesorias.index')}}">
                    <i class="material-icons left">arrow_back</i>
                    </a>
                    Asesorias y Usos
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li><a href="{{route('asesorias.index')}}">Asesorias y Usos</a></li>
                    <li class="active">Indicadores</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <ul class="tabs">
                                <li class="waves-effect waves-light btn btn-flat tab"><a class="tooltipped" onclick="$('#consultar_por').val('por_funcionario'); updateCardMessage();" data-tooltip="Consulta costos y horas de asesorias por los funcionarios del nodo (Experto, Apoyo Técnico y Articulador)" href="#por_funcionario">Consultar por funcionarios</a></li>
                                @if ($can_read_all)
                                    <li class="waves-effect waves-light btn btn-flat tab"><a class="tooltipped" onclick="$('#consultar_por').val('por_fecha_asesoria'); updateCardMessage();" data-tooltip="Consulta costos y horas de asesorias en un rango de fechas en que se realizan las asesorías" href="#por_fecha_asesoria">Consultar por fecha de asesoría</a></li>
                                    <li class="waves-effect waves-light btn btn-flat tab"><a class="tooltipped" onclick="$('#consultar_por').val('por_proyecto_finalizado'); updateCardMessage();" data-tooltip="Consulta costos y horas de asesorias en un rango de fecha de proyectos finalizados" href="#por_proyecto_finalizado">Consultar por proyectos finalizados</a></li>
                                @endif
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col s4 m4 l4">
                                @include('asesorias.indicadores.form')
                            </div>
                            <div class="col s8 m8 l8">
                                <ul class="tabs">
                                    <li id="li_info_asesorias" class="waves-effect waves-light btn btn-flat tab">
                                        <a href="#info_asesorias">Asesorias</a>
                                    </li>
                                    <li id="li_info_equipos" class="waves-effect waves-light btn btn-flat tab">
                                        <a href="#datos_equipos">Equipos</a>
                                    </li>
                                    <li id="li_info_materiales" class="waves-effect waves-light btn btn-flat tab">
                                        <a href="#datos_materiales">Materiales</a>
                                    </li>
                                    <li id="li_info_resumen" class="waves-effect waves-light btn btn-flat tab">
                                        <a href="#info_resumen">Resumen</a>
                                    </li>
                                </ul>
                                <div id="info_asesorias">
                                    <div id="datos_asesorias">
                                        <div class="row card-panel red lighten-3 center"><h5>No se encontraron resultados</h5></div>
                                    </div>
                                    <div id="pagination-asesores" class="pagination"></div>
                                </div>

                                <div id="datos_equipos">
                                    <div id="info_equipos">
                                        <div class="row card-panel red lighten-3 center"><h5>No se encontraron resultados</h5></div>
                                    </div>
                                    <div id="pagination-equipos" class="pagination"></div>
                                </div>

                                <div id="datos_materiales">
                                    <div id="info_materiales">
                                        <div class="row card-panel red lighten-3 center"><h5>No se encontraron resultados</h5></div>
                                    </div>
                                    <div id="pagination-materiales" class="pagination"></div>
                                </div>

                                <div id="info_resumen">
                                    <div id="costosDeAsesorias_column" class="green lighten-3">
                                        <div class="row card-panel">
                                            <h5 class="center">
                                            Para consultar el costo de las asesorias, debes primero realizar la consultas.
                                            </h5>
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
    @include('generico.modal')
@endsection
