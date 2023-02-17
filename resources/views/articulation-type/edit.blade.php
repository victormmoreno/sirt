@extends('layouts.app')
@section('meta-title', config('app.technical_support.title'))
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content ">
            <div class="row no-m-t no-m-b m-r-lg m-l-lg">
                <div class="left left-align">
                    <h5 class="left-align primary-text">
                        <a href="{{route('tipoarticulaciones.index')}}" class="footer-text left-align">
                            <i class="material-icons arrow-l left">arrow_back</i>
                        </a>
                        {{__('articulation-type')}}
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">{{ __('Home') }}</a></li>
                        <li><a href="{{route('tipoarticulaciones.index')}}">{{__('articulation-type')}}</a></li>
                        <li><a href="{{route('tipoarticulaciones.show', $typeArticulation)}}">{{isset($typeArticulation->name) ? $typeArticulation->name : __('articulation-type')}}</a></li>
                        <li class="active">Editar</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="card ">
                        <div class="card-content  black-text">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <h4>Ingresa y configura una nuevo tipo de articulación</h4>
                                    <address>
                                        Ingresa el nombre y confugura como quiere que se muestre la información
                                    </address>
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
                                            <form class="m-t-md"
                                                action="{{ route('tipoarticulaciones.update', $typeArticulation->id)}}"
                                                id="formTypeArticulation" method="POST">
                                                {!! method_field('PUT')!!}
                                                @include('articulation-type.form', ['btnText' => 'Guardar Cambios'])
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

