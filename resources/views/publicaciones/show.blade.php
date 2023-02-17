@extends('layouts.app')
@section('meta-title', 'Novedad - ' . $publicacion->codigo_publicacion)

@section('content')

<main class="mn-inner inner-active-sidebar">
<div class="content">
    <div class="row no-m-t no-m-b">
    <div class="col s12 m12 l12">
        <div class="row">
        <div class="col s12 m6 l6">
            <h5 class="left-align primary-text">
            Novedad - {{$publicacion->titulo}}
            </h5>
        </div>
        </div>
        <div class="row">
        <div class="col s12 m12 l12">
            <div class="card mailbox-content">
            <div class="card-content">
                <div class="mailbox-view">
                <small class="grey-text">Publicado el: {{ $publicacion->fecha_inicio }} por {{ $publicacion->user->nombres }} {{ $publicacion->user->apellidos }}</small>
                <div class="divider"></div>
                <div class="row">
                    {!! $publicacion->contenido !!}
                </div>
                <div class="divider"></div>
                <div class="row center">
                    <a href="{{ \Session::get('login_role') == App\User::IsDesarrollador() ? route('publicacion.index') : route('home') }}" class="btn"><i class="material-icons left">arrow_back</i>Volver</a>
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
