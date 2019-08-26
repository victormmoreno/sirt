@extends('layouts.app')

@section('meta-title', 'Nuevo Laboratorio')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l9">
                        <h5 class="left-align">
                            <a class="footer-text left-align" href="{{route('laboratorio.index')}}">
                                <i class="material-icons arrow-l">
                                    arrow_back
                                </i>
                            </a>
                            Laboratorio
                        </h5>
                    </div>
                    <div class="right col s4 m4 l3 ">
                        <ol class="breadcrumbs">
                        
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('laboratorio.index')}}">Laboratorios</a></li>
                            <li class="active">Nuevo Laboratorio</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card mailbox-content">
                            <div class="card-content">
                                <div class="row no-m-t no-m-b">
                                    <div class="col s12 m12 l12">
                            
                                        <div class="mailbox-view">
                                            <div class="mailbox-view-header">
                                
                                                <div class="center mailbox-buttons">
                                                    <span class="mailbox-title">
                                                        <p class="center">
                                                            Nuevo Laboratorio
                                                        </p>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="mailbox-text">
                                                <form action="{{ route('perfil.contraseña')}}" method="POST" onsubmit="return checkSubmit()">
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
                                                                <span class="title">Nuevo Laboratorio</span>
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
                                                                    <input class="validate" id="txtnombre" name="txtnombre" type="text"  value="{{ old('txtnombre')}}">
                                                                    <label for="txtnombre">Nombre Laboratorio <span class="red-text">*</span></label>
                                                                    @error('txtnombre')
                                                                        <label id="txtnombre-error" class="error" for="txtnombre">{{ $message }}</label>
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
                                                                    <input class="validate" id="txtnewpassword" name="txtnewpassword" type="password">
                                                                    <label for="txtnewpassword">Línea Tecnológica <span class="red-text">*</span></label>
                                                                    @error('txtnewpassword')
                                                                        <label id="txtnewpassword-error" class="error" for="txtnewpassword">{{ $message }}</label>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="input-field col s12 m6 l6 offset-l3 m3">
                                                                    <i class="material-icons prefix">
                                                                        lock
                                                                    </i>
                                                                    <input class="validate" id="txtnewpassword-confirm" name="txtnewpassword_confirmation" type="password" >
                                                                    <label for="txtnewpassword-confirm">Costos Administrativos (%) <span class="red-text">*</span></label>
                                                                    
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
        </div>
    </div>
</main>
@endsection


