@extends('layouts.app')
@section('meta-title', 'Talentos')
@section('content')
@php
  $year = Carbon\Carbon::now()->year;
@endphp
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                              <a class="footer-text left-align" href="{{route('usuario.index')}}">
                                  <i class="material-icons arrow-l">
                                      arrow_back
                                  </i>
                              </a>
                            Usuarios | Talentos
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('usuario.index')}}">Usuarios</a></li>
                            <li class="active">Talentos</li>
                        </ol>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m12 l10">
                                    <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
                                        <span class="card-title center-align">
                                            @if($view == 'activos')
                                            Talentos con acceso y  con proyectos en {{config('app.name')}}
                                            @else
                                            Talentos sin acceso y con proyectos en {{config('app.name')}}
                                            @endif

                                        </span>
                                        <i class="material-icons">
                                            supervised_user_circle
                                        </i>
                                    </div>
                                </div>
                                <div class="col s12 l2">
                                    <div class="click-to-toggle show-on-large hide-on-med-and-down">
                                        <a href="{{route('usuario.search')}}" class="waves-effect waves-light btn-large"><i class="material-icons left">add_circle</i>Nuevo Usuario</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="divider">
                            </div>
                            @includeWhen($view == 'activos', 'users.settings.button_filter', ['url' => route('usuario.usuarios.talento.papelera'), 'message' => 'Ver Talentos sin acceso'])
                            @includeWhen($view == 'inactivos', 'users.settings.button_filter', ['url' => route('usuario.index'), 'message' => 'Ver Talentos con acceso'])
                            <br>
                                
                                
                            @if($view == 'activos')
                            <div class="col s12 m12 l12">
                                <div class="input-field col s12 m12 l12">
                                    <select class="js-states"  tabindex="-1" style="width: 100%" id="anio_proyecto_talento" name="anio_proyecto_talento" onchange="consultarTalentosByGestor();">
                                        @for ($i=2016; $i <= $year; $i++)
                                        <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                                        @endfor
                                    </select>
                                    <label for="anio_proyecto_talento">Seleccione el Año</label>
                                </div>
                            </div>
       
                                 @include('users.table', ['id' => 'talento_activosByGestor_table'] )  
                            @elseif($view == 'inactivos')
                            <div class="col s12 m12 l12">
                                <div class="input-field col s12 m12 l12">
                                    <select class="js-states"  tabindex="-1" style="width: 100%" id="anio_proyecto_talento" name="anio_proyecto_talento" onchange="consultarTalentosByGestorTrash();">
                                        @for ($i=2016; $i <= $year; $i++)
                                        <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
                                        @endfor
                                    </select>
                                    <label for="anio_proyecto_talento">Seleccione el Año</label>
                                </div>
                            </div>
                            @include('users.table', ['id' => 'talento_inactivosByGestor_table'] ) 
                            @endif
                        </div>
                    </div>
                </div>
                <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                    <a href="{{route('usuario.search')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nuevo Usuario">
                         <i class="material-icons">add_circle</i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection