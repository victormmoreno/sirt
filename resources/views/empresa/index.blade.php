
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
                    <h5 class="left left-align primary-text">
                        <i class="material-icons left">
                        business_center
                        </i>
                        Empresas
                    </h5>
                    <div class="right right-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li class="active">Empresas</li>
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
                                            @include('empresa.componentes.titulo')
                                            @can('create', App\Models\Empresa::class)
                                                <a href="{{route('empresa.create')}}" class="bg-secondary white-text btn-flat right show-on-large hide-on-med-and-down m-l-xs">Nueva Empresa</a>
                                            @endcan
                                            <a href="{{route('empresa.search')}}" class="bg-secondary-lighten white-text btn-flat right show-on-large hide-on-med-and-down m-l-xs">Buscar Empresa</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                @include('empresa.table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection