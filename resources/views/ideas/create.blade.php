@extends('spa.layouts.app')

@section('meta-title', 'Registro de Ideas')
@section('meta-content', 'Registro de Ideas')
@section('content-spa')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<main class="mn-inner no-p">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                @if (session()->has('success'))
                <div class="valign-wrapper  col s12 m6 l6 offset-l3 m3">
                    <blockquote>
                        <ul class="collection center-align">
                            <li class="collection-item">
                                <h3 class="center-align">
                                    El SENA te da la bienvenida a su
                                    programa {{config('app.name')}},
                                    pronto nos comunicaremos contigo que presentes tu propuesta ante el comité de ideas. ¡ Entrena para tu pich de 5 minutos !
                                </h3>
                                <h4>El Registro ha sido guardado​ exitosamente.</h4>
                                Regresar al <a href="{{route('/')}}">Inicio</a>
                            </li>
                        </ul>
                    </blockquote>
                </div>
                @else
                <div class="row">
                    <div class="col s12 m12 l12">
                        <h4 class="card-title center-align">Registra tu idea de Proyecto</h4>
                    </div>
                </div>
                <form class="col s12 m12 l12" method="post" action="{{ route('idea.store') }}" onsubmit="return checkSubmit()">
                    @include('ideas.form', [
                        'btnText' => 'Registrar Idea',
                    ])
                </form>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
