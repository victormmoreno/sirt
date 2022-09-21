
@extends('layouts.app')
@section('meta-title', 'Empresas')
@section('meta-content', 'Empresas')
@section('meta-keywords', 'Empresas')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
            <div class="row">
                <div class="col s8 m8 l10">
                    <h5 class="left-align">
                        <i class="material-icons left">
                        business_center
                        </i>
                        Empresas
                    </h5>
                </div>
                <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">Inicio</a></li>
                        <li class="active">Empresas </li>
                    </ol>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="row no-m-t no-m-b">
                                <div class="col s12 m12 l12">
                                    <div class="row no-m-t no-m-b">
                                      @include('empresa.componentes.titulo_for_admin')
                                    </div>
                                </div>
                            </div>
                            <div class="divider"></div>
                            @include('empresa.table')
                        </div>
                    </div>
                </div>
            </div>
            <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
                <p>
                    <a href="{{route('empresa.create')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nueva Empresa">
                        <i class="material-icons">add</i>
                    </a>
                </p>
                <p>
                    <a href="{{route('empresa.search')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Buscar Usuario">
                        <i class="material-icons">search</i>
                    </a>
                </p>
            </div>
        </div>
    </div>
</main>
@endsection