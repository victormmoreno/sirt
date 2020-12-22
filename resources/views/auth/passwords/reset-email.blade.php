@extends('auth.layouts.app')

@section('meta-tittle', 'Cambiar Correo Electrónico')
@section('meta-content', 'Cambiar Correo Electrónico')
@section('meta-keywords', 'Cambiar Correo Electrónico')

@section('content-auth')

<div class="mn-content valign-wrapper" id="app">
    <main class="mn-inner container">
        <div class="valign">
            <div class="row">
                <div class="col s12 m6 l6 offset-l3 offset-m3">
                    <div class="card white darken-1">
                        @if(session()->has('success') || session()->has('error'))
                            <div class="center">
                                <div class="card  {{session('success') ? 'green': ''}} {{session('error') ? 'red': ''}}  darken-1">
                                    <div class="row">
                                        <div class="col s12 m12">
                                            <div class="card-content white-text">
                                                <p>
                                                    {{session('success') ? : session('error')}}
                                                </p>
                                            </div>
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
                                                {{ __('Change email') }}
                                            </div>
                                        </br>
                                    </br>
                                </div>
                            </span>
                            <div class="center-aling">
                                <p class="description text-center">
                                    Complete el formulario para restablecer su dirección de correo electrónico
                                </p>
                            </div>
                            <div class="row">
                                <form action="{{ route('email.send') }}" method="POST" onsubmit="return checkSubmit()">
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
                                        <input autofocus="" class="validate @error('birthdate') is-invalid @enderror" id="birthdate" name="documento" type="text" value="{{ old('documento') }}">
                                        <label for="documento">Documento <span class="red-text">*</span></label>
                                        @error('documento')
                                            <label id="documento-error" class="error" for="documento">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">
                                            event
                                        </i>
                                        <input class="validate datepicker" class="validate @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate" type="text" value="{{ old('birthdate') }}">
                                        <label for="birthdate">Fecha de nacimiento <span class="red-text">*</span></label>
                                        @error('birthdate')
                                            <label id="birthdate-error" class="error" for="birthdate">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">
                                            mail
                                        </i>
                                        <input  class="validate @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}">
                                        <label for="email">Nueva dirección de correo <span class="red-text">*</span></label>
                                        @error('email')
                                            <label id="email-error" class="error" for="email">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">
                                            mail
                                        </i>
                                        <input  class="validate @error('email') is-invalid @enderror" id="email" name="email_confirmation" type="email" value="{{ old('email_confirmation') }}">
                                        <label for="email">Confirme dirección de correo <span class="red-text">*</span></label>
                                        @error('_confirmation')
                                            <label id="_confirmation-error" class="error" for="email">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="col s12 center-align m-t-sm">
                                        <button class="waves-effect waves-light btn center-align " type="submit">
                                            {{ __('register new mail') }}
                                        </button> 
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