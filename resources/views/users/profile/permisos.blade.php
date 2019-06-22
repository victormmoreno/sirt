@extends('layouts.app')

@section('meta-title', 'Roles |' . $user->nombres. ' '. $user->apellidos)

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s10 m10 l10">
                        <h5 class="left-align">
                            <i class="material-icons left">
                                supervised_user_circle
                            </i>
                            Usuarios | Perfil
                        </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card mailbox-content">
                            <div class="card-content">
                                <div class="row no-m-t no-m-b">
                                    <div class="col s12 m5 l3">
                                        <div class="mailbox-list">
                                            <ul>
                                                <li>
                                                    <a href="{{{route('perfil.index')}}}">
                                                        <h4 class="mail-title">
                                                            Información Personal
                                                        </h4>
                                                        <p align="justify" class="hide-on-small-and-down mail-text">
                                                           En este apartado podrás ver y actualizar tu información personal.
                                                        </p>
                                                        
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{{route('perfil.roles')}}}">
                                                        <h4 class="mail-title">
                                                            Roles
                                                        </h4>
                                                        <p align="justify" class="hide-on-small-and-down mail-text">
                                                            En este apartado podrás ver los roles asignados.
                                                        </p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a  href="{{{route('perfil.permisos')}}}">
                                                        <h4 class="mail-title">
                                                            Permisos Adicionales
                                                        </h4>
                                                        <p align="justify" class="hide-on-small-and-down mail-text">
                                                            En este apartado podrás ver los permisos adicionales que se te han asignado.
                                                        </p>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a  href="{{{route('perfil.cuenta')}}}">
                                                        <h4 class="mail-title">
                                                            Cambiar Contraseña
                                                        </h4>
                                                        <p align="justify" class="hide-on-small-and-down mail-text">
                                                            En este apartado podrás ver los permisos cambiar tu contraseña de ingreso a la plataforma {{config('app.name')}}
                                                        </p>
                                                    </a>
                                                </li>
                                                
                                                
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col s12 m7 l9">
                                        <div class="mailbox-options">
                                           <ul>
                                                <li>
                                                    <a href="{{{route('perfil.index')}}}">
                                                        Información Personal
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{{route('perfil.roles')}}}">
                                                        Roles
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{{route('perfil.permisos')}}}">
                                                        Permisos Adicionales
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{{route('perfil.cuenta')}}}">
                                                        Cambiar Contraseña
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="mailbox-view">
                                            <div class="mailbox-view-header">
                                                <div class="left">
                                                    <div class="left">
                                                        <img alt="" class="circle mailbox-profile-image z-depth-1" src="{{ asset('img/profile-image-masculine.png') }}">
                                                        </img>
                                                    </div>
                                                    <div class="left">
                                                        <span class="mailbox-title">
                                                            {{auth()->check() ? auth()->user()->nombres.' '.auth()->user()->apellidos : ''}} 
                                                        </span>

                                                        <span class="mailbox-author">
                                                            
                                                            {{$user->getRoleNames()->implode(', ')}}<br>
                                                            {{$user->fechanacimiento->age}} años
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="right mailbox-buttons">
                                                    <span class="mailbox-title">
                                                       <p class="center">Permisos Adicionales
                                                            <div class="right">
                                                            
        
                                                            <a class="waves-effect waves-light btn m-t-xs dropdown-button "  href='#' data-activates='actifiad'><i class="material-icons right" >cloud</i>Cambiar Información</a>
                                                            <!-- Dropdown Structure -->
                                                            <ul id='actifiad' class='dropdown-content'>
                                                                <li><a href="#!">one</a></li>
                                                                <li><a href="#!">two</a></li>
                                                                <li class="divider"></li>
                                                                <li><a href="#!">three</a></li>
                                                            </ul> 
                                                        </div>
                                                       </p>

                                                    </span>

                                                    
                                                </div>

                                                <div class="right mailbox-buttons">
                                                    
                                                    
                                                    {{-- <a class="waves-effect waves-red btn-flat m-t-xs">
                                                        Delete
                                                    </a> --}}
                                                    
                                                </div>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="mailbox-text">
                                                <div class="row">
                                                    <div class="col s12 m6 l6  ">
                                                        <ul class="collection">
                                                            @forelse($user->permissions as $permission)
                                                                <li class="collection-item avatar">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        credit_card
                                                                    </i>
                                                                    <span class="title">
                                                                        {{$permission->name}}
                                                                    </span>
                                                                    
                                                                    <span class="secondary-content">
                                                                        <i class="material-icons">
                                                                            grade
                                                                        </i>
                                                                    </span>
                                                                    
                                                                </li>
                                                            @empty
                                                            <p>No tienes roles asignados</p>
                                                            @endforelse
                                                            
    
                                                        </ul>
                                                    </div>
                                                    
                                                </div>
                                                <div class="divider mailbox-divider">
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
    </div>
</main>
@endsection
