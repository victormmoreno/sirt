@extends('layouts.app')
@section('meta-title', 'Gráficos')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5>Gráficos</h5>
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
                    <div class="col s12 m6 l6">
                      <div class="card-panel lime lighten-4">
                        <div class="row">
                        <center>
                          <i class="medium material-icons"><a>autorenew</a></i>
                        </center>
                        </div>
                        <div class="row">
                          <h3 class="center"><a href="{{route('grafico.articulacion')}}">Articulaciones</a></h3>
                        </div>
                      </div>
                    </div>
                    <div class="col s12 m6 l6">
                      <div class="card-panel green">
                        <a class="waves-effect waves-light btn-large">EDT's</a>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s12 m6 l6">
                      <div class="card-panel red">
                        <a class="waves-effect waves-light btn-large">Articulaciones</a>
                      </div>
                    </div>
                    <div class="col s12 m6 l6">
                      <div class="card-panel green">
                        <a class="waves-effect waves-light btn-large">EDT's</a>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s12 m6 l6">
                      <div class="card-panel red">
                        <a class="waves-effect waves-light btn-large">Articulaciones</a>
                      </div>
                    </div>
                    <div class="col s12 m6 l6">
                      <div class="card-panel green">
                        <a class="waves-effect waves-light btn-large">EDT's</a>
                      </div>
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
  @include('charlas.modals')
@endsection
