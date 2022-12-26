@extends('layouts.app')
@section('meta-title', 'Metas')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="row">
              <div class="col s8 m8 l10">
                  <h5 class="left-align">
                      <i class="material-icons left">
                        attach_file
                      </i>
                      Metas
                  </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('indicadores')}}">Inicio</a></li>
                      <li class="active">Metas</li>
                  </ol>
              </div>
          </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="center-align">
                <span class="card-title center-align">Registrar metas</span>
              </div>
              <div class="divider"></div>
              <div class="row">
                <div class="col s12 m12 l12">
                    <form action="{{route('indicadores.import.metas')}}" method="POST" enctype="multipart/form-data">
                        @include('indicadores.administrador.metas_form')
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection