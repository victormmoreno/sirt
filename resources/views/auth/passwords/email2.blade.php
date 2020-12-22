@extends('auth.layouts.app')

@section('meta-tittle', 'Reestablecer Contraseña')
@section('meta-content', 'Reestablecer Contraseña')
@section('meta-keywords', 'Reestablecer Contraseña')

@section('content-auth')

<div class="mn-content valign-wrapper" id="app">
    <main class="mn-inner container">
        <div class="valign">
            <div class="row">
                <div class="col s12 m6 l4 offset-l4 offset-m3">
                    <div class="card white darken-1">
                        @if (session('status'))
                            <div class="card green darken-1">
                                <div class="row">
                                    <div class="col s12 m12">
                                        <div class="card-content white-text">
                                            <p class="justify_aling" align="justify">
                                                {{ session('status') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="card-content ">
                            <span class="card-title center-align">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <a href="{{route('/')}}">
                                            <img class="chapter-title responsive-img" width="200px" height="60px" src="{{ asset('img/logonacional_Negro.png') }}"/>
                                        </a>
                                    </div>
                                    <br>
                                        <br>
                                            <div class="col s12 m12 l12">
                                                <div class="divider" style="background:#008981;">
                                                </div>
                                                <a class="footer-text left-align" href="{{route('login')}}">
                                                    <i class="material-icons arrow-l">
                                                        arrow_back
                                                    </i>
                                                </a>
                                                {{ __('Reset Password') }}
                                            </div>
                                        </br>
                                    </br>
                                </div>
                            </span>
                            <div class="center-aling">
                                <p class="description text-center">
                                    Seleccione y escriba el tipo y el número de su documento de identidad.
                                </p>
                            </div>
                            <div class="row">
                                <form action="{{ route('password.email') }}" method="POST" onsubmit="return checkSubmit()">
                                    @csrf
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">
                                            account_box
                                        </i>
                                        <select  name="type_document" style="width: 100%" tabindex="-1"  class="validate @error('type_document') is-invalid @enderror" id="type_document">
                                            @foreach($tiposdocumentos as $value)
                                                <option value="{{$value->id}}" {{old('type_document') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option>
                                            @endforeach
                                        </select>
                                        <label for="type_document">Tipo Documento <span class="red-text">*</span></label>
                                        @error('type_document')
                                            <label id="type_document-error" class="error" for="type_document">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">
                                            assignment_ind
                                        </i>
                                        <input autocomplete="documento" autofocus="" class="validate @error('documento') is-invalid @enderror" id="documento" name="documento" type="text" value="{{ old('documento') }}">
                                        <label for="documento">Documento <span class="red-text">*</span></label>
                                        @error('documento')
                                            <label id="documento-error" class="error" for="documento">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col s12 center-align m-t-sm">
                                        <button class="waves-effect waves-light btn center-align " type="submit">
                                            <i class="material-icons left">
                                                mail
                                            </i>
                                            {{ __('Send Password Reset Link') }}
                                        </button>
                                        <div class="divider"></div>
                                        <small>¿Ya estas registrado? 
                                            <a class="m-t-sm cyan-accent-1-text center-align " href="{{route('login')}}" style="color: #008987">
                                            {{__('Login')}}
                                            </a>
                                        </small>
                                        <br> 
                                        <small>¿Ya no tiene acceso a su correo electrónico?
                                            <a class="m-t-sm cyan-accent-1-text center-align " href="{{route('email.request')}}" style="color: #008987">
                                            {{__('Change email')}}
                                            </a>
                                        </small>
                                        <br><br> 
                                        <a class="m-t-sm cyan-accent-1-text center-align " href="{{route('/')}}" style="color: #008987">
                                            Inicio
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

