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
                                                    <a href="">
                                                        
                                                        
                                                        <h4 class="mail-title">
                                                            Información Personal
                                                        </h4>
                                                        <p class="hide-on-small-and-down mail-text">
                                                           En este apartado podrás ver y actualizar tu información personal.
                                                        </p>
                                                        
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="">
                                                        
                                                
                                                        <h4 class="mail-title">
                                                            Roles
                                                        </h4>
                                                        <p class="hide-on-small-and-down mail-text">
                                                            En este apartado podrás ver los roles asignados.
                                                        </p>
                                                        
                                                    </a>
                                                </li>
                                                <li>
                                                    <a  href="">
                                                        
                                                        <h5 class="mail-author">
                                                            Jonathan Smith
                                                        </h5>
                                                        <h4 class="mail-title">
                                                            I am on my way
                                                        </h4>
                                                        <p class="hide-on-small-and-down mail-text">
                                                            Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit...
                                                        </p>
                                                        <div class="position-top-right p f-12 mail-date">
                                                            12:46 am
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="">
                                                        <div class="mail-checkbox">
                                                            <input class="filled-in" id="mail-checkbox4" type="checkbox">
                                                                <label for="mail-checkbox4">
                                                                </label>
                                                            </input>
                                                        </div>
                                                        <h5 class="mail-author">
                                                            Jonathan Smith
                                                        </h5>
                                                        <h4 class="mail-title">
                                                            I am on my way
                                                        </h4>
                                                        <p class="hide-on-small-and-down mail-text">
                                                            Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit...
                                                        </p>
                                                        <div class="position-top-right p f-12 mail-date">
                                                            12:46 am
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="">
                                                        <div class="mail-checkbox">
                                                            <input class="filled-in" id="mail-checkbox5" type="checkbox">
                                                                <label for="mail-checkbox5">
                                                                </label>
                                                            </input>
                                                        </div>
                                                        <h5 class="mail-author">
                                                            Jonathan Smith
                                                        </h5>
                                                        <h4 class="mail-title">
                                                            I am on my way
                                                        </h4>
                                                        <p class="hide-on-small-and-down mail-text">
                                                            Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit...
                                                        </p>
                                                        <div class="position-top-right p f-12 mail-date">
                                                            12:46 am
                                                        </div>
                                                        <div class="position-bottom-right p mail-attachment">
                                                            <i class="material-icons">
                                                                attachment
                                                            </i>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="">
                                                        <div class="mail-checkbox">
                                                            <input class="filled-in" id="mail-checkbox6" type="checkbox">
                                                                <label for="mail-checkbox6">
                                                                </label>
                                                            </input>
                                                        </div>
                                                        <h5 class="mail-author">
                                                            Jonathan Smith
                                                        </h5>
                                                        <h4 class="mail-title">
                                                            I am on my way
                                                        </h4>
                                                        <p class="hide-on-small-and-down mail-text">
                                                            Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit...
                                                        </p>
                                                        <div class="position-top-right p f-12 mail-date">
                                                            12:46 am
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col s12 m7 l9">
                                        <div class="mailbox-options">
                                            <ul>
                                                <li>
                                                    <a href="">
                                                        Información Personal
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="">
                                                        Roles
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="">
                                                        Permisos Adicionales
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="">
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
                                                       <p class="center">Roles
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
                                                    <div class="col s12 m6 l6 offset-l3 m3 ">
                                                        <ul class="collection">
                                                            @forelse($user->roles as $role)
                                                                <li class="collection-item avatar">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        credit_card
                                                                    </i>
                                                                    <span class="title">
                                                                        {{$role->name}}
                                                                    </span>
                                                                    <p>
                                                                       @if($role->permissions->count())
                                                                        <small>{{$role->permissions->pluck('name')->implode(', ')}}</small>
                                                                      @endif
                                                                        
                                                                    </p>
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
