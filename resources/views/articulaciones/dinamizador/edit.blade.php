@extends('layouts.app')
@section('meta-title', 'Articulaciones')
@section('meta-content', 'Articulaciones')
@section('meta-keywords', 'Articulaciones')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
            <div class="row">
                <div class="col s8 m8 l10">
                    <h5>
                        <a class="footer-text left-align" href="{{route('articulacion')}}" rel="nofollow">
                        <i class="material-icons arrow-l">arrow_back</i>
                        </a> Articulaciones
                    </h5>
                </div>
                <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('articulacion')}}">Articulaciones</a></li>
                        <li class="active">Modificar</li>
                    </ol>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                <div class="row">
                    <div class="col s12 m12 l12">
                    <br>
                    <center>
                        <span class="card-title center-align">Modificar Articulación - <b>{{ $articulacion->articulacion_proyecto->actividad->codigo_actividad }}</b></span>
                    </center>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col s12 m12 l12">
                        <div class="card red lighten-3">
                            <div class="row">
                            <div class="col s12 m12">
                                <div class="card-content white-text">
                                <p><i class="material-icons left">info_outline</i>Los datos marcados con * son obligatorios</p>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <form method="POST" action="{{route('articulacion.update', $articulacion->id)}}" onsubmit="return checkSubmit()">
                        {!! csrf_field() !!}
                        {!! method_field('PUT')!!}
                        <input type="hidden" name="txttipo_articulacion" id="txttipo_articulacion" value="">
                        <div class="row">
                        <div class="col s12 m12 l12">
                            <blockquote>
                            <ul class="collection">
                                <li class="collection-item">Debes tener en cuenta que solo se puede realizar un articulación con un solo grupo de investigación o empresa. <br>En caso de que la articulación se realize con emprendedor (es), estos se deben registrar como talento.</li>
                            </ul>
                            </blockquote>
                        </div>
                        </div>
                        <div class="row">
                        <p class="center card-title">La articulación se está realizando con: </p>
                        <div class="input-field col s12 m12 l12">
                            <p class="center p-v-xs">
                            <input class="with-gap" disabled onchange="contenedores();" name="group1" type="radio" {{ $articulacion->tipo_articulacion == 0 ? 'checked' : '' }} id="IsGrupo" value="0"/>
                            <label for="IsGrupo">Grupo de Investigación</label>
                            </p>
                            <center>
                            <small id="group1-error" class="center-align error red-text"></small>
                            </center>
                        </div>
                        </div>
                        <div class="divider"></div>
                        <div class="row">
                        <div class="input-field col s12 m6 l6">
                            <input disabled type="text" id="txtcodigo_actividad" name="txtcodigo_actividad" value="{{ $articulacion->articulacion_proyecto->actividad->codigo_actividad }}"/>
                            <label for="txtcodigo_actividad">Código de la Articulación</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <input disabled type="text" id="txtnombre" name="txtnombre" value="{{ $articulacion->articulacion_proyecto->actividad->nombre }}"/>
                            <label for="txtnombre">Nombre de la Articulación</label>
                        </div>
                        </div>
                        <div class="row">
                        <div class="input-field col s12 m6 l6">
                            <select id="txtgestor_id" class="js-states" name="txtgestor_id" style="width: 100%;">
                            <option value="">Seleccione el experto</option>
                            @forelse ($gestores as $id => $value)
                                <option value="{{$id}}" {{ $id == $articulacion->articulacion_proyecto->actividad->gestor_id ? 'selected' : '' }} {{ old('txtgestor_id') == $id ? 'selected':'' }} >{{$value}}</option>
                            @empty
                                <option value="">No hay información disponible</option>
                            @endforelse
                            </select>
                            <label for="txtgestor_id">Expertos <span class="red-text">*</span></label>
                            @error('txtgestor_id')
                            <label id="txtgestor_id-error" class="error" for="txtgestor_id">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <input disabled type="text" id="txtlineatecnologica_id" name="txtlineatecnologica_id" value="{{ $articulacion->articulacion_proyecto->actividad->gestor->lineatecnologica->nombre }}">
                            <label for="txtlineatecnologica_id">Línea Tecnológica</label>
                        </div>
                        </div>
                        <div class="divider"></div>
                        <center>
                        <button type="submit" class="cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
                        <a href="{{route('articulacion')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
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
