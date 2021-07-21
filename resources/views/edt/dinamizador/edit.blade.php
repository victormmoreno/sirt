@extends('layouts.app')
@section('meta-title', 'Articulaciones')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <div class="row">
              <div class="col s8 m8 l10">
                  <h5 class="left-align">
                      <a class="footer-text left-align" href="{{route('edt')}}">
                      <i class="left material-icons">arrow_back</i>
                    </a> Edt's 
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li><a href="{{route('edt')}}">Edt</a></li>
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
                    <span class="card-title center-align">Modificar Edt - <b>{{ $edt->codigo_edt }}</b></span>
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
                  <form method="POST" action="{{route('edt.update', $edt->id)}}" onsubmit="return checkSubmit()">
                    {!! csrf_field() !!}
                    {!! method_field('PUT')!!}
                    <div class="divider"></div>
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input disabled type="text" id="txtcodigo_actividad" name="txtcodigo_actividad" value="{{ $edt->codigo_edt }}"/>
                        <label for="txtcodigo_actividad">Código de la Edt</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input disabled type="text" id="txtnombre" name="txtnombre" value="{{ $edt->nombre }}"/>
                        <label for="txtnombre">Nombre de la Edt</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <select id="txtgestor_id" class="js-states" name="txtgestor_id" style="width: 100%;">
                          <option value="">Seleccione el Gestor</option>
                          @forelse ($gestores as $id => $value)
                            <option value="{{$id}}" {{ $id == $edt->gestor_id ? 'selected' : '' }} {{ old('txtgestor_id') == $id ? 'selected':'' }} >{{$value}}</option>
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
                        <input disabled type="text" id="txtlineatecnologica_id" name="txtlineatecnologica_id" value="{{ $edt->nombre_linea }}">
                        <label for="txtlineatecnologica_id">Línea Tecnológica</label>
                      </div>
                    </div>
                    <div class="divider"></div>
                    <center>
                      <button type="submit" class="cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
                      <a href="{{route('edt')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
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
