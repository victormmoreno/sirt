@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="row">
          <div class="col s8 m8 l10">
              <h5 class="left-align">
                  <a class="footer-text left-align" href="{{ route('proyecto') }}">
                    <i class="material-icons arrow-l">arrow_back</i>
                  </a> Proyectos
              </h5>
          </div>
          <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
              <ol class="breadcrumbs">
                  <li><a href="{{route('home')}}">Inicio</a></li>
                  <li><a href="{{route('proyecto')}}">Proyectos</a></li>
                  <li class="active">Editar</li>
              </ol>
          </div>
          </div>
        <div class="card">
          <div class="card-content">
            <br>
            <center>
              <span class="card-title center-align">Modificar Proyecto - {{$proyecto->codigo_proyecto}}</span>
            </center>
            <div class="divider"></div>
            <form action="{{route('proyecto.update', $proyecto->id)}}" method="POST" onsubmit="return checkSubmit()">
              {!! method_field('PUT')!!}
              {!! csrf_field() !!}
              @if($errors->any())
                <div class="card red lighten-3">
                  <div class="row">
                    <div class="col s12 m12">
                      <div class="card-content white-text">
                        <p><i class="material-icons left"> info_outline</i>  Los datos marcados con * son obligatorios</p>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
              <div class="row">
                <div class="input-field col s12 m6 l6">
                  <input disabled type="text" id="txtcodigo_proyecto" name="txtcodigo_proyecto" value="{{ $proyecto->codigo_proyecto }}">
                  <label for="txtcodigo_proyecto">Código de Proyecto</label>
                </div>
                <div class="input-field col s12 m6 l6">
                  <input disabled type="text" id="txtnombreproyecto" name="txtnombreproyecto" value="{{ $proyecto->nombre }}">
                  <label for="txtnombreproyecto">Nombre de Proyecto</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12 m6 l6">
                  <select id="txtgestor_id" class="js-states" name="txtgestor_id" style="width: 100%;">
                    <option value="">Seleccione el Gestor</option>
                    @forelse ($gestores as $id => $value)
                      <option value="{{$id}}" {{ $id == $proyecto->gestor_id ? 'selected' : '' }} {{ old('txtgestor_id') == $id ? 'selected':'' }} >{{$value}}</option>
                    @empty
                      <option value="">No hay información disponible</option>
                    @endforelse
                  </select>
                  <label for="txtgestor_id">Gestores <span class="red-text">*</span></label>
                  @error('txtgestor_id')
                    <label id="txtgestor_id-error" class="error" for="txtgestor_id">{{ $message }}</label>
                  @enderror
                </div>
                <div class="input-field col s12 m6 l6">
                  <input disabled type="text" id="txtlineatecnologica_id" name="txtlineatecnologica_id" value="{{ $proyecto->nombre_linea }}">
                  <label for="txtlineatecnologica_id">Línea Tecnológica</label>
                </div>
              </div>
              <div class="divider"></div>
              <center>
                <button class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
                <a href="{{ route('proyecto') }}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
              </center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
