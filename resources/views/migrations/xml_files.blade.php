@extends('layouts.app')
@section('meta-title', 'Migraciones')
@section('content')
@php
    $now = Carbon\Carbon::now();
    $yearNow = $now->year;
    $monthNow = $now->month;
@endphp
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <i class="material-icons left">attach_file</i>Migraciones
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li class="active">Migraciones</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="primary-text">
                                    <div class="mailbox-view-header">
                                        <div class="center-align">
                                            <h1 class="card-title center-align text-2xl no-m">Migracion de archivos</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="row card bg-info">
                            <div class="card-content white-text center-align">
                                <h5><i class="material-icons center-align">
                                        info_outline
                                    </i>
                                    Aquí puedes generar un archivo xml con la información necesaria para descargar los archivos de forma masiva con un programa FTP
                                </h5>
                            </div>
                        </div>
                        <div class="row">
                            @if ($errors->any())
                                @if(collect($errors->all())->count() > 1)
                                <span class="red-text">{{collect($errors->all())->count()}} errores</span>
                                @else
                                <span class="red-text">Tienes {{collect($errors->all())->count()}} error</span>
                                @endif
                            @endif
                            <div class="col s12 m12 l12">
                                <form action="{{route('migracion.archivos.xml')}}" method="POST" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6">
                                            <input type="text" id="txtarchivos_desde" name="txtarchivos_desde" class="datepicker picker__input black-text" value="{{Carbon\Carbon::create($yearNow, $monthNow, 1)->toDateString() }}">
                                            <label for="txtarchivos_desde" class="black-text">Desde</label>
                                        </div>
                                        <div class="input-field col s12 m6 l6 black-text">
                                            <input type="text" id="txtarchivos_hasta" name="txtarchivos_hasta" class="datepicker picker__input black-text" value="{{Carbon\Carbon::now()->toDateString()}}">
                                            <label for="txtarchivos_hasta" class="black-text">Hasta</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m12 l12">
                                            <input type="text" id="txtruta_guardado" name="txtruta_guardado" length="200" required maxlength="200"
                                                value="">
                                            <label for="txtruta_guardado">Descripción donde se guardarán los archivos de forma local<span class="red-text">*</span></label>
                                            <small id="txtruta_guardado-error" class="error red-text"></small>
                                        </div>
                                    </div>
                                    <center>
                                        <button type="submit" class="waves-effect bg-secondary white-text btn center-aling">
                                            <i class="material-icons right">done</i>
                                            Generar XML
                                        </button>
                                    </center>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
