@extends('layouts.app')
@section('meta-title', 'Caracterización SIRT')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <a class="footer-text left-align " href="{{route('tag.index')}}">
                        <i class="material-icons arrow-l left">arrow_back</i>
                    </a>Caracterización del SIRT
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="active">Editar caracterización</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
            <div class="card">
            <div class="card-content">
                <div class="row">
                <div class="center-align">
                    <span class="card-title center-align primary-text"><b>Editar caracterización</b></span>
                </div>
                <div class="divider"></div>
                <form id="frmEtiquetas_Create" action="{{route('tag.update', $tag)}}" method="POST">
                    {{ method_field('PUT') }}
                    @include('tags.forms.form', [
                    'btnText' => 'Guardar'])
                </form>
                </div>
            </div>
            </div>
        </div>

        </div>
    </div>
</main>
@endsection
