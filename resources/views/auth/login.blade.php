@extends('auth.layouts.app')

@section('content-auth')
     <div class="loader-bg"></div>
  <div class="loader">
    <div class="preloader-wrapper big active">
      <div class="spinner-layer spinner-blue">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>
      <div class="spinner-layer spinner-red">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>
      <div class="spinner-layer spinner-yellow">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>
      <div class="spinner-layer spinner-green">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>
    </div>
  </div>
    <div class="mn-content valign-wrapper" id="app">
        <main class="mn-inner container">
            <div class="valign">
                <div class="row">
                    <div class="col s12 m6 l6 offset-l3 offset-m3">
                        <div class="card white darken-1">
                            <div class="card-content ">
                                <span class="card-title center-align">
                                    <div class="row">
                                        <div class="col s12 m12 l12">
                                            <a href="">
                                                <img  width="200px" height="60px" src="{{ asset('img/logonacional_Negro.png') }}" class="chapter-title responsive-img"></img>
                                            </a>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="col s12 m12 l12">
                                            <div class="divider" style="background:#008981;"></div>
                                            <a class="footer-text left-align" href="">
                                                <i class="material-icons arrow-l">arrow_back</i>
                                            </a>INICIAR SESIÓN
                                        </div>
                                    </div>
                                </span>
                
                <div class="row">
                  <form   method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-field col s12">
                      <i class="material-icons prefix">mail</i>
                      
                      <input id="email" type="email" class="validate @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Ingresa tu correo">
                      <label for="email" class="active">{{ __('E-Mail Address') }}</label>
                      @error('email')
                       <span class="helper-text">
                             <strong>{{ $message }}</strong>
                       </span>
                     @enderror
                    </div>
                    <div class="input-field col s12">
                      <i class="material-icons prefix">lock_outline</i>
                      
                      <input id="password" type="password" class="validate @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Ingresa tu contraseña">
                      <label for="password" class="active">{{ __('Password') }}</label>
                      @error('password')
                            <span class="helper-text">
                             <strong>{{ $message }}</strong>
                       </span>
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

                      
                      <button type="submit" class="waves-effect waves-light btn center-align">
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
