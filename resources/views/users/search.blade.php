@extends('layouts.app')

@section('meta-title', 'Usuarios')

@section('content')
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
                            Usuarios
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('usuario.index')}}">Usuarios</a></li>
                            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsInfocenter())
                            <li class="active">Filtrar Usuario</li>
                            @else
                            <li class="active">Nuevo Usuario</li>
                            @endif
                            
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m12 l12">                                
                                    <div class="mailbox-view">
                                        <div class="search-users">
                                            <div class="container">
                                                <br><br>
                                                <h2 class="header center hand-of-Sean-fonts orange-text text-darken-3">Usuarios</h2>
                                                <div class="row center">
                                                  <h5 class="header col s12 light black-text text-lighten-1"> Digite el número de documento para verificar si el usuario está registrado.</h5>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="container">
                                                <div class="row">
                                                  <div class="col s12">
                                                    <div class="row">
                                                      <div class="input-field col s12">
                                                        <i class="material-icons prefix">search</i>
                                                        <input type="text" id="search_user" class="autocomplete">
                                                        <label for="search_user">Número de documento</label>
                                                      </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="input-field col s6  center-align offset-s3">
                                                            <button onclick="userSearch.queryUserByDocumento()" class="waves-effect waves-light btn-large"><i class="material-icons right">search</i>Buscar Usuario</button>
                                                        </div>
                                                    </div>
                                                    <div id="response-alert"></div>
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
            </div>
        </main>
@endsection


