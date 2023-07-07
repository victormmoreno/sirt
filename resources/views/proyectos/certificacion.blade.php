@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
            <h5>
            <a class="footer-text left-align" href="{{route('proyecto')}}">
                <i class="material-icons arrow-l">arrow_back</i>
            </a> Proyectos de Base Tecnológica
            </h5>
            <div class="card">
            <div class="card-content">
                <div class="row">
                <h4 class="center">Generar cartas de certificación para el proyecto {{$proyecto->nombre}}</h4>
                </div>
                <div class="row">
                    <form id="frmCartaCertificacion" action="{{route('pdf.proyecto.certificacion', $proyecto->id)}}" method="POST">
                        @include('proyectos.forms.form_certificacion', [
                        'btnText' => 'Modificar'])
                    </form>
                </div>
            </div>
            </div>
        </div>

        </div>
    </div>
</main>
@endsection
