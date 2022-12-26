@extends('layouts.app')
@section('meta-title', 'Ideas de Proyecto')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('idea.index')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> Ideas de Proyecto
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <br>
              <center>
                <span class="card-title center-align"><b>Reasignar idea de proyecto - {{ $idea->nombre_proyecto }}</b></span>
              </center>
              <div class="divider"></div>
              <div class="card-panel red lighten-3">
                <div class="card-content white-text">
                  <a class="btn-floating red"><i class="material-icons left">info_outline</i></a>
                  <span>Los elementos con (*) son obligatorios</span>
                </div>
              </div>
              <br/>
              <form id="frmIdeaReasignar" name="frmIdeaReasignar" action="{{ route('idea.update.nodo', $idea) }}" method="POST">
                {!! method_field('PUT')!!}
                @csrf
                <div class="row">
                  <input type="hidden" name="txtidea_id" value="{{$idea->id}}">
                    <div class="input-field col s12 m6 l6">
                      <select id="txtnodo_id" class="js-states" name="txtnodo_id" style="width: 100%;">
                        <option value="">Seleccione el nodo</option>
                        @foreach ($nodos as $nodo)
                          <option value="{{$nodo->id}}" {{ $nodo->id == $idea->nodo->id ? 'selected' : '' }} {{ old('txtnodo_id') == $nodo->id ? 'selected':'' }} >{{$nodo->nodos}}</option>
                        @endforeach
                      </select>
                      <label for="txtnodo_id">Nodos <span class="red-text">*</span></label>
                      @error('txtnodo_id')
                        <label id="txtnodo_id-error" class="error" for="txtnodo_id">{{ $message }}</label>
                      @enderror
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <input disabled type="text" id="txtnombre_idea" name="txtnombre_idea" value="{{$idea->codigo_idea}} - {{ $idea->nombre_proyecto }}">
                      <label for="txtnombre_idea">Idea de proyecto</label>
                    </div>
                  </div>
                <div class="divider"></div>
              <div class="center">
                <button type="submit" value="send" class="waves-effect cyan darken-1 btn center-aling">
                  <i class="material-icons right">done</i>
                  Cambiar nodo.
                </button>
                <a href="{{route('idea.detalle', $idea->id)}}" class="waves-effect red lighten-2 btn center-aling">
                  <i class="material-icons right">backspace</i>Cancelar
                </a>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('ideas.modals')
</main>
@endsection