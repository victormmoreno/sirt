@extends('layouts.app')
@section('meta-title', 'Gráficos')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <div class="row">
              <div class="col s8 m8 l10">
                  <h5 class="left-align">
                      <i class="material-icons left">
                          insert_chart
                      </i>
                      Gráficos
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Gráficos</li>
                  </ol>
              </div>
          </div>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <div class="center-align">
                        <span class="card-title center-align">Gráficos</span>
                      </div>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <div class="row">
                    <div class="col s12 m4 l4">
                      <a class="red" href="{{route('grafico.articulacion')}}">
                        <div class="card indigo lighten-4">
                          <div class="card-content center">
                            <i class="left material-icons black-text">autorenew</i>
                            <span class="black-text">Articulaciones</span>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col s12 m4 l4">
                      <a href="{{route('grafico.edt')}}">
                        <div class="card indigo lighten-4">
                          <div class="card-content center">
                            <i class="left material-icons black-text">hearing</i>
                            <span class="black-text">Edt's</span>
                          </div>
                        </div>
                      </a>
                    </div>
                    <div class="col s12 m4 l4">
                      <a href="{{route('grafico.proyectos')}}">
                        <div class="card indigo lighten-4">
                          <div class="card-content center">
                            <i class="left material-icons black-text">library_books</i>
                            <span class="black-text">Proyectos</span>
                          </div>
                        </div>
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
