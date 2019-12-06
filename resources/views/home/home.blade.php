@extends('layouts.app')
@section('meta-title','Inicio')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="middle-content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m8 l8">
          <div class="card stats-card">
            <div class="card-content">
              <span class="card-title">Novedades</span>
              <span class="stats-counter"><span class="counter"></span><small>Aquí podrá ver los últimos anuncios o novedades del aplicativo.</small></span>
              @include('publicaciones.table', [
                'id' => 'tblnovedades_Otros',
                'rol' => \Session::get('login_role')
              ])
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
