@extends('layouts.app')
@section('meta-title', 'Perfil |' . $user->nombres. ' '. $user->apellidos)
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <i class="material-icons left">supervised_user_circle</i>Usuarios | Perfil
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li class="active">Perfil</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
                    <div class="col s12 m12 l12">
                        <div class="card mailbox-content">
                            <div class="card-content">
                                <div class="row no-m-t no-m-b">
                                    <div class="col s12 m12 l12">
                                        @include('users.profile.nav.navbar')
                                        <div class="mailbox-view">
                                            <div class="mailbox-view-header">
                                                @include('users.profile.nav.header')
                                                <div class="right mailbox-buttons">
                                                    <span class="mailbox-title">
                                                        <p class="center">
                                                            Cambia o recupera su contraseña
                                                        </p>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="right">
                                                <small>{{{$user->email}}}  </small>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="mailbox-text">
                                                <form action="{{ route('perfil.password')}}" method="POST" onsubmit="return checkSubmit()">
                                                    {!! csrf_field() !!}
                                                    {!! method_field('PUT')!!}
                                                    <div class="row">
                                                        <div class="col s12 m3 l3">
                                                            <blockquote>
                                                                <ul class="collection">
                                                                    <li class="collection-item">
                                                                        <h5 class="title center"><b> Contraseña</b></h5>
                                                                        <p>Después de una actualización correcta de la contraseña, se le redirigirá a la página de inicio de sesión donde podrá iniciar sesión con su nueva contraseña.</p>
                                                                    </li>

                                                                </ul>
                                                            </blockquote>
                                                        </div>
                                                        <div class="col s12 m9 l9"><br>
                                                            <div class="center">
                                                                <span class="title">Cambia o recupera su contraseña</span>
                                                            </div>
                                                            <div class="divider mailbox-divider">
                                                            </div>
                                                            @if(session()->has('status') || session()->has('error'))
                                                                <div class="center">
                                                                    <div class="card  {{session('status') ? 'green': ''}} {{session('error') ? 'red': ''}}  darken-1">
                                                                        <div class="row">
                                                                            <div class="col s12 m10">
                                                                                <div class="card-content white-text">
                                                                                    <p>
                                                                                        <i class="material-icons left">info_outline</i>
                                                                                        {{session('status') ? : session('error')}}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="row">
                                                                <div class="input-field col s12 m6 l6 offset-l3 m3">
                                                                    <i class="material-icons prefix">
                                                                        lock_open
                                                                    </i>
                                                                    <input class="validate" id="password" name="password" type="password"  value="{{ old('password')}}">
                                                                    <label for="password">Contraseña actual <span class="red-text">*</span></label>
                                                                    @error('password')
                                                                        <label id="password-error" class="error" for="password">{{ $message }}</label>
                                                                    @enderror
                                                                    <div class="center-align">
                                                                        <small class="black-text">Debe proporcionar su contraseña actual para poder cambiarla.</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="input-field col s12 m6 l6 offset-l3 m3">
                                                                    <i class="material-icons prefix">
                                                                        lock
                                                                    </i>
                                                                    <input class="validate" id="newpassword" name="newpassword" type="password">
                                                                    <label for="newpassword">Nueva contraseña <span class="red-text">*</span></label>
                                                                    @error('newpassword')
                                                                        <label id="newpassword-error" class="error" for="newpassword">{{ $message }}</label>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="input-field col s12 m6 l6 offset-l3 m3">
                                                                    <i class="material-icons prefix">
                                                                        lock
                                                                    </i>
                                                                    <input class="validate" id="newpassword-confirm" name="newpassword_confirmation" type="password" >
                                                                    <label for="newpassword-confirm">Confirmar contraseña <span class="red-text">*</span></label>

                                                                </div>
                                                            </div>
                                                            <div class="divider mailbox-divider">
                                                        </div>
                                                        <div class="row">
                                                            <div class="center">
                                                                <button type="submit" class="waves-effect waves-teal darken-2 btn-flat m-t-xs">
                                                                    Guardar la contraseña
                                                                </button>
                                                                <a href="{{route('perfil.password.reset')}}" class="waves-effect waves-red btn-flat m-t-xs">
                                                                    He olvidado mi contraseña
                                                                </a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                  </div>
                                                </form>
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


