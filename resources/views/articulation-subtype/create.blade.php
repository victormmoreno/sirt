@extends('layouts.app')
@section('meta-title', __('articulation-subtype'))
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b">
                <div class="left left-align">
                    <h5 class="left-align orange-text text-darken-3">
                        <i class="material-icons left">autorenew</i>{{__('articulation-subtype')}}
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">{{ __('Home') }}</a></li>
                        <li><a href="{{route('articulation-stage')}}">{{__('articulation-subtype')}}</a></li>
                        <li class="active">Nuevo</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content  black-text">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <h4>Ingresa y configura una nuevo {{__('articulation-subtype')}}</h4>
                                    <address>
                                        Confugura como quiere que se muestre la información
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
                                                <p>Ingresa y selecciona la visibilidad del {{__('articulation-subtype')}}</p>
                                            </address>
                                            <form  class="m-t-md" action="{{ route('tiposubarticulaciones.store')}}" id="formArticualtionSubtype" method="POST">
                                                @include('articulation-subtype.form', ['btnText' => 'Guardar'])
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

