@extends('layouts.guest')
@section('meta-title', 'Red Tecnoparque Colombia')
@section('meta-content', 'Inicio')
@section('content')
    <section class="section white no-pad-top ">
        <div class="section bg-secondary z-depth-1" style="min-height: 100vh;">
            <div class="container m-t-xxl">
                <div class="row" style="margin-top: 15vh;">
                    <div class="col s12 l6">
                        <div class="white-text p-v-xxl m-t-xxl ">
                            <h1 class="white-text p-v-xxl m-t-xxl m-b-xxl">{{ config('app.name') }}</h1>
                            <p class="white-text start-header-paragraph-text  m-b-xxl">
                                Bienvenidos a <span class="primary-text">{{ config('app.name') }}</span> el sistema de
                                información de la <span class="primary-text">Red Tecnoparque Colombia</span>.
                            </p> <a class="waves-effect waves-light btn bg-tertiary" href="{{ route('registro') }}"
                                rel="canonical">Registrate</a> <a class="waves-effect waves-light btn bg-primary"
                                href="{{ route('login') }}" rel="canonical">Iniciar sesión</a>
                        </div>
                    </div>
                    <div class="col s6 l6">
                        <div class="container p-v-xxl m-t-xxl">
                            <img src="{{ asset('img/hero.jpg') }}" class="image-responsive" width="600" height="447">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
