@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('proyecto')}}">
            <i class="material-icons arrow-l left">arrow_back</i>
          </a> Proyectos de Base Tecnológica
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              @include('proyectos.navegacion_fases')
              <div class="divider"></div>
              <br />
              <form action="{{route('proyecto.update.gestor', $proyecto->id)}}" method="POST" name="frmUpdateGestor">
                {!! method_field('PUT')!!}
                @csrf
                <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <select id="txtgestor_id" class="js-states" name="txtgestor_id" style="width: 100%;">
                        <option value="">Seleccione el Gestor</option>
                        @forelse ($gestores as $id => $value)
                          <option value="{{$id}}" {{ $id == $proyecto->articulacion_proyecto->actividad->gestor_id ? 'selected' : '' }} {{ old('txtgestor_id') == $id ? 'selected':'' }} >{{$value}}</option>
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
                      <input disabled type="text" id="txtlineatecnologica_id" name="txtlineatecnologica_id" value="{{ $proyecto->sublinea->linea->nombre }}">
                      <label for="txtlineatecnologica_id">Línea Tecnológica</label>
                    </div>
                  </div>
                  <div class="divider"></div>
                <center>
                  <button type="submit" value="send" class="waves-effect cyan darken-1 btn center-aling">
                    <i class="material-icons right">done</i>
                    Cambiar gestor.
                  </button>
                  <a href="{{route('proyecto')}}" class="waves-effect red lighten-2 btn center-aling">
                    <i class="material-icons right">backspace</i>Cancelar
                  </a>
                </center>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
