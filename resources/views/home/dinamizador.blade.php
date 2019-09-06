@extends('layouts.app')
@section('meta-title','')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="middle-content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m3 l3 ">
          <a href="{{ route('proyecto.pendientes') }}" class="black-text">
            <div class="card green lighten-3 stats-card">
              <div class="card-content">
                <h6>Proyectos pendientes de aprobación para iniciar</h6>
              </div>
              <div class="progress green darken-3 stats-card-progress">
                <div class="determinate"></div>
              </div>
            </div>
          </a>
        </div>
        <div class="col s12 m3 l3">
          <div class="card stats-card">
            <div class="card-content">
              <span class="card-title">Dinamizadores</span>
              <span class="stats-counter"><span class="counter"></span><small> Dinamizadores</small></span>
            </div>
            <div class="progress stats-card-progress">
              <div class="determinate"></div>
            </div>
          </div>
        </div>
        <div class="col s12 m3 l3">
          <div class="card stats-card">
            <div class="card-content">
              <span class="card-title">Gestores</span>
              <span class="stats-counter"><span class="counter"></span><small>Gestores</small></span>
            </div>
            <div class="progress stats-card-progress">
              <div class="determinate"></div>
            </div>
          </div>
        </div>
        <div class="col s12 m3 l3">
          <div class="card stats-card">
            <div class="card-content">
              <span class="card-title">Talentos</span>
              <span class="stats-counter"><span class="counter"></span><small>Talentos</small></span>
            </div>
            <div class="progress stats-card-progress">
              <div class="determinate"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <div class="card card-transparent">
            <div class="card-content">
              <center>
                <p class="card-title aling-center">Bienvenido <span class="secondary-title"> Sistema Nacional de la Red de Tecnoparques Colombia</span></p>
              </center>
              <div class="row">
                <div class="col s12 m12 l10 offset-l1">
                  <img class="materialboxed responsive-img" src="{{ asset('img/logonacional_Negro.png') }}" alt="sena | Tecnoparque">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <div id="loginrole" class="modal" style="width: 30%">
    <div class="modal-content">
      <h4 class="center red-text ">Roles {{auth()->user()->nombres}} {{auth()->user()->apellidos}}</h4>
      <div class="col s12 m12 l12">
        <ul class="collection with-header">
          @forelse(auth()->user()->getRoleNames() as  $name)
            <li class="collection-item">
              <p class="p-v-xs">
                <input class="with-gap" id="rolesesion{{$name}}" name="rolesesion" type="radio" value="{{$name}}" />
                <label for="rolesesion{{$name}}">{{$name}}</label>
              </p>
            </li>
          @empty
            <p>No tienes roles asignados</p>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
@endsection
