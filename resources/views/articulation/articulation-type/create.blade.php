@extends('layouts.app')
@section('meta-title', config('app.technical_support.title'))
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="container ">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card card-transparent">
                    <div class="card-content  black-text">
                        <div class="row ">
                            <div class="left left-align">
                                <a class="footer-text " href="#">
                                    <i class="material-icons arrow-l mt-2">
                                        arrow_back
                                    </i>
                                </a>
                                Configuración
                            </div>
                            <div class="right right-align">
                                <ol class="breadcrumbs">
                                    <li><a href="{{route('home')}}">Inicio</a></li>
                                    <li ><a href="{{route('tipoarticulaciones.index')}}">Tipos Articulaciones</a></li>
                                    <li class="active">Nuevo tipo Articulación</li>
                                </ol>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m8 l8">
                                <h4>Ingresa y configura una nuevo tipo de articulación</h4>
                                <address>
                                    Ingresa el nombre y confugura como quiere que se muestre la información
                                </address>
                            </div>
                            <div class="col s12 m4 l4 right-align hide-on-small-only">
                                <i class="large material-icons">settings</i>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="row">
                            <div class="col s12 m12 l12 container-fluid">
                                <div class="card card-transparent mt-2 ">
                                    <div class="card-content ">
                                        <address>
                                            <strong>General</strong><br>
                                            <p>Ingresa y selecciona la visibilidad del tipo de articulación</p>
                                        </address>
                                        <form  class="m-t-md" action="{{ route('tipoarticulaciones.store')}}" id="formTypeArticulation" method="POST">
                                            @include('articulation.articulation-type.form', ['btnText' => 'Guardar'])
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
</main>
@endsection

