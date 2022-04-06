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
                <span class="card-title center-align"><b>Idea de proyecto - {{ $idea->codigo_idea }}</b></span>
              </center>
              <div class="divider"></div>
              <div class="row">
                <div class="col s12 m3 l3">
                  <ul class="collection with-header">
                    <li class="collection-header"><h5>Opciones</h5></li>
                    @include('ideas.opciones', ['idea' => $idea])
                    {{-- @if ($idea->estadoIdea->nombre == 'En registro' || $idea->estadoIdea->nombre == 'Postulado')
                    <li class="collection-item">
                      <a href="{{route('idea.reasignar.nodo', $idea->id)}}">
                        <div class="card-panel green lighten-2 black-text center">
                          Cambiar idea de nodo<button data-target="modal1" class="btn-floating btn-flat modal-trigger"><i class="material-icons right black-text">help</i></button>
                        </div>
                      </a>
                    </li>
                    @endif --}}
                    <li class="collection-item">
                      @include('ideas.historial_cambios')
                    </li>
                  </ul>
                </div>
                <div class="col s12 m9 l9">
                  @include('ideas.detalle')
                  <center>
                    <a href="{{route('idea.index')}}" class="waves-effect red lighten-2 btn center-aling">
                      <i class="material-icons right">backspace</i>Cancelar
                    </a>
                  </center>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection