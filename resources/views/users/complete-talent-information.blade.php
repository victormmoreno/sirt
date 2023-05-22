{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

@extends('layouts.app')
@section('meta-title', 'Inicio')
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="card card-transparent">
                    <div class="card-content">
                        <div class="center-align">
                            <p class="card-title aling-center">Bienvenido <span class="secondary-title"> Sistema Nacional de
                                    la Red de Tecnoparques Colombia</span>
                            </p>
                        </div>
                        <div class="row">
                            <div class="col s12 m12 l10 offset-l1">
                                <img class="materialboxed responsive-img"
                                    src="{{ asset('img/logo-tecnoparque-green.svg') }}" alt="sena | Tecnoparque">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div id="complete_talent_information" class="modal modal-fixed-footer">
        <div class="modal-content">
            <center>
                <h4 class="center-aling">Complete informacion</h4>
            </center>
            <div class="divider"></div>
            <div id=""></div>
        </div>
        <div class="modal-footer white-text">
            <a href="#!" class="modal-action modal-close waves-effect waves-primary btn-flat ">Cerrar</a>
        </div>
    </div>

@endsection
@push('script')
    <script>
        $('#complete_talent_information').openModal({
            dismissible: false,
            opacity: 0.7,
            startingTop: '20%',
            endingTop: '60%',
        });
    </script>
@endpush
