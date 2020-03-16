@extends('layouts.app')

@section('meta-title', 'Acceso |' . $user->nombres. ' '. $user->apellidos)

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s10 m10 l10">
                        <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                            <a class="footer-text left-align" href="{{route('usuario.index')}}">
                                <i class="material-icons arrow-l">
                                    arrow_back
                                </i>
                            </a>
                            Usuarios | Acceso
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('usuario.index')}}">Usuarios</a></li>
                            <li class="active">Acceso</li>
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
                                                {{-- @include('users.profile.nav.header') --}}
                                                <div class="right mailbox-buttons">
                                                    <span class="mailbox-title">
                                                        <p class="center">
                                                            Cambia Acceso a la plataforma {{config('app.name')}} al usuario {{ $user->nombres}} {{$user->apellidos}}
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
                                                <form action="{{ route('usuario.usuarios.updateacceso', $user->documento)}}" method="POST" onsubmit="return checkSubmit()">
                                                    {!! csrf_field() !!}
                                                    {{ method_field('PUT') }}
                                                    <div class="row">
                                                        <div class="col s12 m3 l3">
                                                            <blockquote>
                                                                <ul class="collection">
                                                                    <li class="collection-item">
                                                                        <h5 class="title center green-complement-text"><b> Acceso</b></h5>
                                                                    <p>Después de una actualización correcta del acceso a la plataforma, si el usuario fue Inhabilitado no podrá acceder a la plataforma {{config('app.name')}}</p>
                                                                    </li>
                                                
                                                                </ul>
                                                            </blockquote>
                                                        </div>
                                                        <div class="col s12 m9 l9"><br>
                                                            
                                                            <div class="center">
                                                                <span class="title green-complement-text">Cambia Acceso a la plataforma {{config('app.name')}}</span>
                                                            </div>
                                                            <div class="divider mailbox-divider">
                                                            </div>
                                                            @if(session()->has('success') || session()->has('error'))
                                                                <div class="center">
                                                                    <div class="card  {{session('success') ? 'green': ''}} {{session('error') ? 'red': ''}}  darken-1">
                                                                        <div class="row">
                                                                            <div class="col s12 m10">
                                                                                <div class="card-content white-text">
                                                                                    <p>
                                                                                        <i class="material-icons left">info_outline</i>
                                                                                        {{session('success') ? : session('error')}}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                            @endif
                                                            
                            
                                                            
                                                            <div class="row ">
                                                                <div class="center">
                                                                    <div class="input-field col s12 m12 l12 offset-l6 offset-m12">
                                                                        <div class="switch m-b-md">
                                                
                                                                          <label class="active">Aceeso a plataforma *</label>
                                                                            <label>
                                                                                SI
                                                                                @if(isset($user->estado))
                                                                                <input type="checkbox" id="txtestado" name="txtestado" {{$user->estado != 1 ? 'checked' : old('txtestado')}}>
                                                                                @else
                                                                                <input type="checkbox" id="txtestado" name="txtestado" {{old('txtestado') == 'on' ? 'checked' : ''}}>
                                                                                @endif
                                                                                <span class="lever"></span>
                                                                                NO
                                                                            </label>
                                                                            <small id="txtestado-error"  class="error red-text"></small>
                                                                        </div>
                                                                        @error('txtestado')
                                                                            <label id="txtestado-error" class="error" for="txtestado">{{ $message }}</label>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                
                                                            </div>
                                                            <div class="divider mailbox-divider">
                                                        </div>
                                                        <div class="row">
                                                            <div class="center">
                                                                <button type="submit" class="waves-effect waves-teal darken-2 btn-flat m-t-xs">
                                                                    Guardar Cambios
                                                                </button>
                                                                
                                                        
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


