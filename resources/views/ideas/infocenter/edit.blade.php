@extends('layouts.app')
@section('meta-title', 'Ideas')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l9">
                        <h5 class="hand-of-Sean-fonts orange-text text-darken-3">
                            <a class="footer-text left-align " href="{{route('idea.index')}}">
                                <i class="material-icons arrow-l">arrow_back</i>
                            </a> Ideas de Proyecto
                        </h5>
                    </div>
                    <div class="col s4 m4 l3 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('idea.index')}}">Ideas de Proyecto</a></li>
                            <li class="active">Modificar</li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <center>
                        <span class="card-title center-align hand-of-Sean-fonts orange-text text-darken-3">Modificar Idea de Proyecto - {{ $idea->codigo_idea }}</span>
                        </center>
                    </div>
                </div>
                    
                <form action="{{ route('idea.update', $idea->id)}}" method="POST" onsubmit="return checkSubmit()">
                    {!! method_field('PUT')!!}
                    @include('ideas.form', [
                        'btnText' => 'Modificar',
                    ])
                </form>
                    
            </div>
        </div>
    </div>
</main>
@endsection
