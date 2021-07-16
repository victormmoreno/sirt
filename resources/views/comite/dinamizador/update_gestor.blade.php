@extends('layouts.app')
@section('meta-title', 'CSIBT')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('csibt.detalle', $comite->id)}}">
            <i class="material-icons arrow-l left">arrow_back</i>
          </a> CSIBT
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="divider"></div>
              <br />
              <form action="{{route('csibt.update.gestor', [$idea, $comite])}}" method="POST" name="frmUpdateGestorIdea">
                {!! method_field('PUT')!!}
                @csrf
                <div class="row">
                  <h5 class="center">Cambiar el experto de la idea: <b>{{$idea->codigo_idea}} - {{$idea->nombre_proyecto}}</b></h5>
                </div>
                <div class="row">
                    <div class="input-field col s12 m6 l6 offset-m3 offset-l3">
                      <select id="txtgestor_id" class="js-states" name="txtgestor_id" style="width: 100%;">
                        <option value="">Seleccione el Experto</option>
                        @forelse ($gestores as $id => $nombres_gestor)
                          <option value="{{$id}}" {{ $id == $idea->gestor_id ? 'selected' : '' }} {{ old('txtgestor_id') == $id ? 'selected':'' }} >{{$nombres_gestor}}</option>
                        @empty
                          <option value="">No hay información disponible</option>
                        @endforelse
                      </select>
                      <label for="txtgestor_id">Expertos <span class="red-text">*</span></label>
                      @error('txtgestor_id')
                        <label id="txtgestor_id-error" class="error" for="txtgestor_id">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                  <div class="divider"></div>
                <center>
                  <button type="submit" value="send" class="waves-effect cyan darken-1 btn center-aling">
                    <i class="material-icons right">done</i>
                    Cambiar Experto.
                  </button>
                  <a href="{{route('csibt.detalle', $comite->id)}}" class="waves-effect red lighten-2 btn center-aling">
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
