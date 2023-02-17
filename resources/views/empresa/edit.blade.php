@extends('layouts.app')
@section('meta-title', 'Empresas')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
            <div class="row">
                <h5 class="left primary-text">
                    <a class="primary-text" href="{{route('empresa.detalle', $empresa->id)}}">
                        <i class="left material-icons">arrow_back</i>
                    </a> Empresas
                </h5>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li><a href="{{route('empresa.detalle', $empresa->id)}}">Empresa</a></li>
                        <li>Cambiar información {{$empresa->nit}}</li>
                    </ol>
                </div>
            </div>
            <div class="card">
            <div class="card-content">
                <div class="row">
                <div class="col s12 m12 l12">
                    <br>
                    <div class="center primary-text">
                        <span class="card-title center-align">Cambiar información de la empresa - {{$empresa->nombre}}</span>
                    </div>
                    <div class="divider"></div>
                    <form id="formEditCompany"  action="{{route('empresa.update', $empresa->id)}}" method="POST">
                    {!! csrf_field() !!}
                    {!! method_field('PUT')!!}
                    <div class="card red lighten-3">
                        <div class="row">
                        <div class="col s12 m12">
                            <div class="card-content white-text">
                            <p><i class="material-icons left"> info_outline</i> Los datos marcados con * son obligatorios</p>
                            </div>
                        </div>
                        </div>
                    </div>
                    @include('empresa.form', ['vista' => 'empresa'])
                    <div class="divider"></div>
                    <div class="center">
                        <button type="submit" class="btn bg-secondary center-aling"><i class="material-icons right">send</i>Modificar</button>
                        <a href="{{route('empresa.detalle', $empresa->id)}}" class="btn bg-danger center-aling"><i class="material-icons left">backspace</i>Cancelar</a>
                    </div>
                    </form>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</main>
@endsection
