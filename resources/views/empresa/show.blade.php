@extends('layouts.app')
@section('meta-title', 'Empresas')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <div class="row">
          <h5 class="left primary-text">
            <a class="primary-text" href="{{route('empresa')}}">
              <i class="material-icons arrow-l left">arrow_back</i>
            </a> Empresas
          </h5>
          <div class="right right-align show-on-large hide-on-med-and-down">
            <ol class="breadcrumbs">
                <li><a href="{{route('home')}}">Inicio</a></li>
                <li><a href="{{route('empresa')}}">Empresas</a></li>
                <li>Detalle {{$empresa->nit}}</li>
            </ol>
        </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <br>
              <div class="center primary-text">
                <span class="card-title center-align"><b>Detalle de la empresa</b></span>
              </div>
              <div class="divider"></div>
              <div class="row">
                @can('showOptions', $empresa)
                    @include('empresa.componentes.options')
                @endcan
                <div class="col s12 {{auth()->user()->can('showOptions', $empresa) ? 'm8 m8' : 'm12 l12'}}">
                  @include('empresa.detalle')
                  <div class="center">
                    <a href="{{route('empresa')}}" class="btn bg-danger center-aling">
                      <i class="material-icons left">backspace</i>Volver
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
