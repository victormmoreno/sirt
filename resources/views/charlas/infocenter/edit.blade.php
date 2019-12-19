@extends('layouts.app')
@section('meta-title', 'Charlas Informativas')
@section('meta-content', 'Charlas Informativas')
@section('meta-keywords', 'Charlas Informativas')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <div class="row">
            <div class="col s12 m9 l9">
                <h5 class="left-align">
                      <a class="footer-text left-align" href="{{route('charla')}}">
                          <i class="material-icons arrow-l">
                              arrow_back
                          </i>
                      </a>
                    Charlas Informativas
                </h5>
            </div>
            <div class="col s12 m3 l3 rigth-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li><a href="{{route('charla')}}">Charlas Informativas</a></li>
                    <li class="active">Modificar Charla</li>
                </ol>
            </div>
        </div>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <center><span class="card-title center-align">Modificar Charla Informativa - {{ $charla->codigo_charla }}</span></center>
                <form method="post" id="formCharlaInformativaEdit" action="{{route('charla.update', $charla->id)}}">
                  {!! method_field('PUT')!!}
                  {!! csrf_field() !!}
                  @include('charlas.infocenter.form', [
                    'btnText' => 'Modificar'
                  ])
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
