@extends('layouts.app')
@section('meta-title','')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
  <main class="mn-inner inner-active-sidebar">
    <div class="middle-content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="card card-transparent">
                    <div class="card-content">
                        <div class="center-align">
                            <p class="card-title aling-center">Bienvenido <span class="secondary-title"> Sistema Nacional de la Red de Tecnoparques Colombia</span>
                            </p>
                        </div>
                        <div class="row">
                            <div class="col s12 m12 l10 offset-l1">
                                <img class="materialboxed responsive-img"
                                     src="{{ asset('img/logo-tecnoparque-green.svg') }}" alt="sena | Tecnoparque">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </main>
@endsection
