@extends('layouts.app')

@section('meta-title','')

@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="middle-content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m3 l3 ">
        <div class="card stats-card">
          <div class="card-content">
            <div class="card-options">
              <ul>
                <li class="red-text"><span class="badge cyan lighten-1">Colombia</span></li>
              </ul>
            </div>
            <span class="card-title">Nodos</span>
            <span class="stats-counter"><span class="counter"></span><small>En el país</small></span>
          </div>
          <div class="progress stats-card-progress">
            <div class="determinate"></div>
          </div>
        </div>
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
  <div class="inner-sidebar">
    <span class="inner-sidebar-title center-aling"><b></b> Admintradores </span>
    <div class="message-list">
      

    </div>
  

  </div>
</main>
@endsection
