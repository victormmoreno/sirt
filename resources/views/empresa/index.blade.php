@extends('layouts.app')
@section('meta-title', 'Empresas')
@section('meta-content', 'Empresas')
@section('meta-keywords', 'Empresas')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <div class="row">
            <div class="col s8 m8 l10">
                <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                    <i class="material-icons left">
                        business_center
                    </i>
                    Empresas
                </h5>
            </div>
            <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li class="active">Empresas </li>
                </ol>
            </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="row">
                  <div class="col s12 m10 l10">
                    <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
                      <span class="card-title center-align">Empresas de Tecnoparque</span>
                    </div>
                  </div>
                </div>
                <center>
                </center>
                <div class="divider"></div>
                @include('empresa.table')
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection