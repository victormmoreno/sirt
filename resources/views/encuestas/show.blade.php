@extends('layouts.guest')
@section('meta-title', 'Encuesta de percepción')
@section('meta-content', 'Encuesta de percepción')
@section('content')
    <div class="section white">
        <div class="container">
            <div class="row  no-m-t no-m-b">
                <div class="col s12 m12 l12 ">
                    <div class="content">
                        <form id="formSaveSurvey" method="POST" action="{{ route('encuesta.answer') }}"
                            onsubmit="return checkSubmit()">
                            @csrf
                            @include('encuestas.forms.form')
                            <div class="col s12 center-align m-t-sm">
                                <button type="submit" id="login-btn"
                                    class="waves-effect waves-light btn bg-secondary center-align">
                                    <i class="material-icons left">send</i>
                                    Enviar resultados
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
