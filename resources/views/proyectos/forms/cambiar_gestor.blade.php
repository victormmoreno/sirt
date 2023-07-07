@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5 class="primary-text">
          <a class="footer-text left-align" href="{{route('proyecto')}}">
            <i class="material-icons arrow-l left">arrow_back</i>
          </a> Proyectos de Base Tecnológica
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="divider"></div>
              <br />
            <center>
              <span class="card-title center-align"><b>Proyecto - {{ $proyecto->present()->proyectoCode() }}</b></span>
            </center>
            <div class="row card-panel green lighten-5">
                <h5 class="center">Cambiando el experto asesor del proyecto</h5>
            </div>
            <div class="divider"></div>
              <form action="{{route('proyecto.update.gestor', $proyecto->id)}}" method="POST" name="frmUpdateGestor">
                {!! method_field('PUT')!!}
                @csrf
                <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <select id="txtgestor_id" class="js-states browser-default select2" name="txtgestor_id" style="width: 100%;">
                        <option value="">Seleccione el experto</option>
                        @forelse ($gestores as $id => $gestor)
                          <option value="{{$gestor->id}}" {{ $gestor->id == $proyecto->experto_id ? 'selected' : '' }} {{ old('txtgestor_id') == $gestor->id ? 'selected':'' }} >{{$gestor->nombres}} {{$gestor->apellidos}}</option>
                        @empty
                          <option value="">No hay información disponible</option>
                        @endforelse
                      </select>
                      <label for="txtgestor_id" class="active">Expertos <span class="red-text">*</span></label>
                      @error('txtgestor_id')
                        <label id="txtgestor_id-error" class="error" for="txtgestor_id">{{ $message }}</label>
                      @enderror
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <input disabled type="text" id="txtlineatecnologica_id" name="txtlineatecnologica_id" value="{{ $proyecto->sublinea->linea->nombre }}">
                      <label for="txtlineatecnologica_id">Línea Tecnológica</label>
                    </div>
                </div>
                <div class="center">
                  <button type="submit" class="waves-effect waves-light btn bg-secondary center-align">
                    <i class="material-icons left">send</i>
                    Guardar
                  </button>
                  <a href="{{ route('proyecto.inicio', $proyecto->id) }}" class="waves-effect waves-light btn bg-danger center-align">
                    <i class="material-icons right">backspace</i>Cancelar
                  </a>
                </div>
            </div>
        </div>
    </main>
@endsection
