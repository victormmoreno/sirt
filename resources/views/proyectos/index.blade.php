@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
    @php
    $year = Carbon\Carbon::now();
    $year = $year->isoFormat('YYYY');
    @endphp
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="row">
                        <div class="col s8 m8 l10">
                            <h5 class="left-align primary-text">
                                <i class="left material-icons">library_books</i>Proyectos de Base Tecnológica
                            </h5>
                        </div>
                        <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                            <ol class="breadcrumbs">
                                <li><a href="{{route('home')}}">Inicio</a></li>
                                <li class="active">Proyectos</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="row">
                                        <div class="col s12 m8 l8">
                                            <div class="center-align">
                                                <span class="card-title center-align primary-text">Proyectos de {{ session()->get('login_role') == App\User::IsExperto() ? auth()->user()->nombres .' '. auth()->user()->apellidos : 'Tecnoparque' }} </span>
                                            </div>
                                        </div>
                                        {{-- @can('create', App\Models\Tag::class)
                                            <div class="col s12 m4 l4 ">
                                                <a  href="{{route('tag.create')}}" class="waves-effect waves-grey bg-secondary white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Agregar etiqueta</a>
                                            </div>
                                        @endcan --}}
                                        @can('create', App\Models\Proyecto::class)
                                            <div class="col s12 m4 l4 ">
                                                <a  href="{{route('proyecto.create')}}" class="waves-effect waves-grey bg-secondary white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Nuevo Proyecto</a>
                                            </div>
                                        @endcan
                                    </div>
                                    <div class="divider"></div>
                                    @can('showActivadorFilter', App\Models\Proyecto::class)
                                        @include('proyectos.filtros.administrador')
                                    @elsecan('showExpertoFilter', App\Models\Proyecto::class)
                                        @include('proyectos.filtros.experto')
                                    @elsecan('showPersonalNodoFilter', App\Models\Proyecto::class)
                                        @include('proyectos.filtros.personal_nodo')
                                    @elsecan('showTalentoFilter', App\Models\Proyecto::class)
                                        @include('proyectos.table')
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('proyectos.modals')
@endsection
