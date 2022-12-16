@extends('layouts.app')
@section('meta-title', 'Ideas de Proyecto')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <div class="row">
          <h5 class="left left-align primary-text">
            <a class="footer-text left-align" href="{{route('idea.index')}}">
              <i class="material-icons arrow-l left primary-text">arrow_back</i>
            </a> Ideas de Proyecto
          </h5>
          <div class="right right-align show-on-large hide-on-med-and-down">
            <ol class="breadcrumbs">
                <li><a href="{{route('home')}}">Inicio</a></li>
                <li><a href="{{route('idea.index')}}">Ideas de proyecto</a></li>
                <li class="active">{{$idea->codigo_idea}}</li>
            </ol>
          </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <br>
              <div class="center">
                <span class="card-title center-align primary-text"><b>Idea de proyecto - {{ $idea->codigo_idea }}</b></span>
              </div>
              <div class="divider"></div>
              <div class="row">
                <div class="col s12 m3 l3">
                  <div class="collection with-header">
                    <h5 class="collection-header">Opciones</h5>
                    @include('ideas.opciones', ['idea' => $idea])
                    @include('ideas.historial_cambios')
                  </div>
                </div>
                <div class="col s12 m9 l9">
                  @include('ideas.detalle')
                  <div class="center">
                    <a href="{{route('idea.index')}}" class="waves-effect bg-danger btn center-aling">
                      <i class="material-icons left">backspace</i>Cancelar
                    </a>
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
@endsection