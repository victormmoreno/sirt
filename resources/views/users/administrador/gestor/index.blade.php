@extends('layouts.app')
@section('meta-title', 'Gestores')
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
                            Usuarios | Gestores
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('usuario.index')}}">Usuarios</a></li>
                            <li class="active">Gestores</li>
                        </ol>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m12 l10">
                                    <div class="center-align">
                                        <span class="card-title center-align hand-of-Sean-fonts orange-text text-darken-3">

                                            @if($view == 'activos')
                                            Gestores con acceso a {{config('app.name')}}
                                            @else
                                            Gestores sin acceso a {{config('app.name')}}
                                            @endif
                                        </span>
                                        <i class="material-icons orange-text text-darken-3">
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
                            @includeWhen($view == 'activos', 'users.settings.button_filter', [$eventAll = 'UserAdministradorGestor.downloadAllGestor(1)',$event= 'UserAdministradorGestor.downloadGestor(1)','url' => route('usuario.gestor.papelera'), 'message' => 'Ver Gestores sin acceso'])
                            @includeWhen($view == 'inactivos', 'users.settings.button_filter', [$eventAll = 'UserAdministradorGestor.downloadAllGestor(0)',$event= 'UserAdministradorGestor.downloadGestor(0)','url' => route('usuario.gestor.index'), 'message' => 'Ver Gestores con acceso'])
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <label class="active" for="selectnodo">Nodo <span class="red-text">*</span></label>
                                    @if($view == 'activos')
                                    <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" id="selectnodo" onchange="UserAdministradorGestor.selectGestoresPorNodo()">
                                    @elseif($view == 'inactivos')
                                    <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" id="selectnodo" onchange="UserAdministradorGestor.selectGestoresPorNodoTrash()">
                                    @endif

                                        <option value="">Seleccione nodo</option>
                                        @foreach($nodos as $id => $nodo)
                                          <option value="{{$id}}">{{$nodo}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <br>

                            @if($view == 'activos')

                                 @include('users.table', ['id' => 'gestor_table_activos'] )
                            @elseif($view == 'inactivos')

                            @include('users.table', ['id' => 'gestor_table_inactivos'] )
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
