@extends('layouts.app')
@section('meta-title', 'Empresas')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
            <h5>
            <a class="footer-text left-align" href="{{route('empresa.detalle', $empresa->id)}}">
                <i class="left material-icons">arrow_back</i>
            </a> Empresas
            </h5>
            <div class="card">
            <div class="card-content">
                <div class="row">
                <div class="col s12 m12 l12">
                    <br>
                    <center>
                    <span class="card-title center-align">Cambiar responsable de la empresa - {{$empresa->nombre}}</span>
                    </center>
                    <div class="divider"></div>
                    <form id="formEditResponsable" action="{{route('empresa.update.responsable', $empresa->id)}}" method="POST">
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
                    @include('empresa.form_responsable')
                    <div class="divider"></div>
                    <center>
                        <button  type="submit" class="waves-effect waves-light btn">Cambiar responsable</button>
                        <a href="{{route('empresa.detalle', $empresa->id)}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                    </center>
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