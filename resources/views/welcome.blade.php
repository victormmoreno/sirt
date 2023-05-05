@extends('layouts.guest')
@section('meta-title', 'Red Tecnoparque Colombia')
@section('meta-content', 'Inicio')

@section('content')
    <header class="no-padding">
        <div class="navbar-fixed">
            <nav class="navfeature bg-primary">
                <div class="container nav-wrapper">
                    <a href="" class="waves-effect waves-light">
                        <span class="">
                            <img src="{{ asset('img/logo_nuevo.svg') }}" alt="{{config('app.name')}}"
                                width="45"
                                style="vertical-align: middle;margin-bottom:10px;margin-right:10px;"></span>
                                <span id="header-large" style="font-weight:400;font-size:2rem;">| SIRT</span>
                    </a>


                    <ul id="nav-mobile" class="hide-on-med-and-down right">
                        <li class="menu-item">
                            <a href="#">Inicio</a>
                        </li>
                        <li class="menu-item">
                            <a href="#">Registrase</a>
                        </li>
                        <li class="menu-item">
                            <a href="#">Iniciar Sesión</a>
                        </li>
                    </ul>
                    <a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi mdi-menu"></i></a>
                </div>
            </nav>
        </div>
        <div class="side-nav-start">
            <ul id="slide-out" class="side-nav" style="transform: translateX(-100%);">

                <li class="menu-item">
                    <a href="#">Inicio</a>
                </li>
                <li class="menu-item">
                    <a href="#">Registrase</a>
                </li>
                <li class="menu-item">
                    <a href="#">Iniciar Sesión</a>
                </li>
            </ul>
        </div>
    </header>
    {{-- </main> --}}
    <main class="mn-inner no-p">
        <section class="section white no-pad-top">
            <div class="section bg-secondary z-depth-1 ">
                <div class="container">
                    <div class="row">
                        <div class="col s12 l6">
                            <div class="white-text p-v-xxl m-t-xxl ">
                                <h1 class=" white-text p-v-xxl m-t-xxl m-b-xxl">{{ config('app.name') }}</h1>
                                <p class="white-text start-header-paragraph-text  m-b-xxl">
                                    Bienvenidos a <span class="primary-text">{{ config('app.name') }}</span> el sistema de información de la <span class="primary-text">Red Tecnoparque Colombia</span>.
                                </p> <a  class="waves-effect waves-light btn modal-trigger"
                                    >Registrate</a> <a
                                    class="waves-effect waves-light btn bg-primary  modal-trigger"
                                    >Iniciar sesión</a>
                            </div>
                        </div>
                        <div class="col s6 l6">
                            <div class="container p-v-xxl m-t-xxl">
                                <img
                                    src="{{ asset('img/hero.jpg') }}"
                                    class="image-responsive" width="600" height="447"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
