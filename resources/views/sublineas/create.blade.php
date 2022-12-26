@extends('layouts.app')
@section('meta-title', 'Sublineas')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <a class="footer-text left-align" href="{{route('sublineas.index')}}">
                        <i class="material-icons arrow-l left">
                            arrow_back
                        </i>
                    </a>
                    Sublineas
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li><a href="{{route('sublineas.index')}}">sublíneas</a></li>
                    <li class="active">Nueva sublínea</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <div class="center-align">
                                    <span class="card-title center-align primary-text">
                                        Nueva Sublinea
                                    </span>
                                </div>
                                <div class="divider"></div>
                                <div class="col s12 m12 l12">
                                    <form action="{{ route('sublineas.store')}}" method="POST" onsubmit="return checkSubmit()">
                                        @include('sublineas.form', [
                                            'btnText' => 'Guardar',
                                        ])
                                    </form>
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
