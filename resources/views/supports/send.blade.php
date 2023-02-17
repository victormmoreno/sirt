@extends('layouts.app')
@section('meta-title', config('app.technical_support.title'))
@section('content')
<main class="mn-inner inner-active-sidebar">

    <div class="bg-primary z-depth-2">
        <div class="container ">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="card card-transparent no-m ">
                        <div class="card-content  white-text">
                            <div class="row">
                                <div class="col s12 m6 l6">
                                    <h4>{{config('app.technical_support.title')}}</h4>
                                    <address>
                                        {{config('app.technical_support.contact.email')}}<br>
                                        {{config('app.technical_support.contact.address')}}
                                        {{config('app.technical_support.contact.phone')}}
                                    </address>
                                </div>
                                <div class="col s12 m6 l6 right-align hide-on-small-only">
                                    <i class="large material-icons">sms</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col s12 m10 l6 offset-l3 offset-m1 z-depth-3">
            <div class="card card-transparent mt-2 ">
                <div class="card-content ">
                    <address>
                        <strong>{{config('app.name')}}</strong><br>
                    </address>
                </div>
                <div class="card-content ">
                    <span class="card-title">MANTENGÁMONOS EN CONTACTO</span>
                    @include('supports.form')
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

