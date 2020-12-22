@extends('auth.layouts.app')

@section('meta-tittle', 'Inicio Sesión')
@section('meta-content', 'Inicio Sesión')
@section('meta-keywords', 'Inicio Sesión')

@section('content-auth')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<div class="mn-content valign-wrapper" id="app">
    <main class="mn-inner container">
      <div class="valign">
          <div class="row">
              <div class="col s12 m6 l6 offset-l3 offset-m3">
                  <div class="card white darken-1">
                    <div class="center">
                          @if (session('status') || session()->has('success'))
                            <div class="card green darken-1">
                                <div class="row">
                                    <div class="col s12 m12">
                                      <div class="center">
                                        <div class="card-content white-text center-align">
                                            <p class="center-aling text-center" align="justify">
                                                {{ session()->has('status') ? session('status') : '' }}
                                                {{ session()->has('success') ? session('success') : '' }}
                                            </p>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                      </div>
                      <div class="card-content ">
                          <span class="card-title center-align">
                              <div class="row">
                                  <div class="col s12 m12 l12">
                                      <a href="{{route('/')}}">
                                          <img  width="200px" height="60px" src="{{ asset('img/logonacional_Negro.png') }}" class="chapter-title responsive-img"></img>
                                      </a>
                                  </div>
                                  <br>
                                  <br>
                                  <div class="col s12 m12 l12">
                                      <div class="divider" style="background:#008981;"></div>
                                        <a class="footer-text left-align" href="{{route('/')}}">
                                            <i class="material-icons arrow-l">arrow_back</i>
                                        </a>INICIAR SESIÓN
                                  </div>
                                </div>
                              </div>
                            </span>
                            <div class="row">
                              <form   method="POST" action="{{ route('login') }}" onsubmit="return checkSubmit()">
                                @csrf
                                <div class="input-field col s12">
                                  <i class="material-icons prefix">mail</i>

                                  <input id="email" type="email" class="validate @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus placeholder="Ingresa tu correo">
                                  <label for="email" class="active">{{ __('E-Mail Address') }}</label>
                                  @error('email')
                                   <label id="email-error" class="error" for="email">{{ $message }}</label>
                                 @enderror
                                </div>
                                <div class="input-field col s12">
                                  <i class="material-icons prefix">lock_outline</i>

                                  <input id="password" type="password" class="validate @error('password') is-invalid @enderror" name="password"  autocomplete="current-password" value="{{ old('password') }}" placeholder="Ingresa tu contraseña">
                                  <label for="password" class="active">{{ __('Password') }}</label>
                                  @error('password')
                                       <label id="password-error" class="error" for="password">{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="col s12 center-align m-t-sm">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col s12 center-align m-t-sm">


                                  <button type="submit" id="login-btn" class="waves-effect waves-light btn center-align">
                                        <i class="material-icons left">fingerprint</i>
                                                {{ __('Login') }}
                                            </button>
                                  <br><br>

                                  @if (Route::has('password.request'))
                                        <a class="m-t-sm  darken-text text-darken-2 center-align" style="color: #008987" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif

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
