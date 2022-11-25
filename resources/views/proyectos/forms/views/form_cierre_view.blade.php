@extends('layouts.app')
@section('meta-title', 'Proyectos de Desarrollo Tecnológico')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <h5 class="primary-text">
                <a class="footer-text left-align" href="{{route('proyecto')}}">
                    <i class="material-icons arrow-l">arrow_back</i>
                </a> Proyectos de Base Tecnológica
                </h5>
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            @include('proyectos.titulo')
                            <form id="frmProyectos_FaseCierre_Update" action="{{route('proyecto.update.cierre', $proyecto->id)}}" method="POST">
                                {!! method_field('PUT')!!}
                                @include('proyectos.forms.form_cierre')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
