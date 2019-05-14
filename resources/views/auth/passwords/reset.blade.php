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
                                            <a href="{{ route('/') }}">
                                                <img  width="200px" height="60px" src="{{ asset('img/logonacional_Negro.png') }}" class="chapter-title responsive-img"></img>
                                            </a>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="col s12 m12 l12">
                                            <div class="divider" style="background:#008981;"></div>
                                            {{ __('Reset Password') }}
                                        </div>
                                    </div>
                                </span>
                                <div class="row">
                                  <form   method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="input-field col s12">
                                      <i class="material-icons prefix">mail</i>
                                      <input id="email" type="email" class="validate @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                      
                                      <label for="email" >{{ __('E-Mail Address') }}</label>
                                      @error('email')
                                       <span class="helper-text">
                                             <strong>{{ $message }}</strong>
                                       </span>
                                     @enderror
                                    </div>
                                    <div class="input-field col s12">
                                      <i class="material-icons prefix">lock_outline</i>
                                      <input id="password" type="password" class="validate @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                     
                                      <label for="password" >{{ __('Password') }}</label>
                                      @error('password')
                                            <span class="helper-text">
                                             <strong>{{ $message }}</strong>
                                       </span>
                                        @enderror
                                    </div>

                                    <div class="input-field col s12">
                                      <i class="material-icons prefix">lock_outline</i>
                                      
                                      <input id="password-confirm" type="password" class="validate" name="password_confirmation" required autocomplete="new-password">
                                     
                                      <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                      
                                    </div>

                        

                                    <div class="col s12 center-align m-t-sm">

                                            <button type="submit" class="btn btn-primary">
                                                        <i class="material-icons left">fingerprint</i>
                                                {{ __('Reset Password') }}
                                            </button>
                                            <br><br>
                                            <a class="m-t-sm  darken-text text-darken-2 center-align" style="color: #008987" href="{{ route('/') }}">
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
