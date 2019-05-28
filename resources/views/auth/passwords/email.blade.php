@extends('auth.layouts.app')

@section('content-auth')

<div class="mn-content valign-wrapper" id="app">
    <main class="mn-inner container">
        <div class="valign">
            <div class="row">
                <div class="col s12 m6 l4 offset-l4 offset-m3">
                    <div class="card white darken-1">
                        <div class="card-content ">
                            <span class="card-title center-align">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <a href="">
                                            <img class="chapter-title responsive-img" width="200px" height="60px" src="{{ asset('img/logonacional_Negro.png') }}"/>
                                        </a>
                                    </div>
                                    <br>
                                        <br>
                                            <div class="col s12 m12 l12">
                                                <div class="divider" style="background:#008981;">
                                                </div>
                                                <a class="footer-text left-align" href="">
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
                                <p align="center" class="description text-center">
                                    Ingresa tu email aquí debajo para enviarte tu nueva contraseña
                                </p>
                                @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                                @endif
                            </div>
                            <div class="row">
                                <form action="{{ route('password.email') }}" method="POST">
                                    @csrf
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">
                                            mail
                                        </i>
                                        <input autocomplete="email" autofocus="" class="validate @error('email') is-invalid @enderror" id="email" name="email" required="" type="email" value="{{ old('email') }}">
                                        <label for="email">
                                            {{ __('E-Mail Address') }}
                                         </label>
                                        @error('email')
                                            <span class="helper-text">
                                                 <strong>{{ $message }}</strong>
                                           </span>
                                        @enderror
                                        
                                    </div>
                                    <div class="col s12 center-align m-t-sm">
                                        
                                        <button class="waves-effect waves-light btn center-align " type="submit">
                                            <i class="material-icons left">
                                                mail
                                            </i>
                                            {{ __('Send Password Reset Link') }}
                                        </button>
                                        <br>
                                            <br>
                                                <a class="m-t-sm cyan-accent-1-text center-align " href="" style="color: #008987">
                                                    Inicio
                                                </a>
                                            </br>
                                        </br>
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

