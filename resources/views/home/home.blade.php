@extends('layouts.app')
@section('meta-title','Inicio')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
  <main class="mn-inner inner-active-sidebar">
    <div class="middle-content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <div class="card card-transparent">
            <div class="card-content">
              <center>
                <p class="card-title aling-center">Bienvenido <span class="secondary-title"> Sistema Nacional de la Red de Tecnoparques Colombia</span></p>
              </center>
              <div class="row">
                <div class="col s12 m12 l10 offset-l1">
                    <img class="materialboxed responsive-img" src="{{ asset('img/logo-tecnoparque-green.svg') }}" alt="sena | Tecnoparque">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- modal  -->
  <div id="loginrole" class="modal" style="width: 30%">
    <div class="modal-content">
      <h4 class="center red-text ">Roles {{auth()->user()->nombres}} {{auth()->user()->apellidos}}</h4>
      <div class="col s12 m12 l12">
        <ul class="collection with-header">
          {{-- <li class="collection-header center"><h6><b>Roles</b></h6></li> --}}
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
@push('script')
  <script>
    $(document).ready(function() {

    });
  </script>
@endpush
