@extends('layouts.app')
@section('meta-title','')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="middle-content">
      <div class="row no-m-t no-m-b">
        {{-- {{$data['actualizacion']}} --}}
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
@endsection
