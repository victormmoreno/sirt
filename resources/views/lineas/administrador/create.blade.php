@extends('layouts.app')

@section('meta-title', 'Nueva Linea Tecnologica')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align">
                            <a class="footer-text left-align" href="{{route('lineas.index')}}">
                                  <i class="material-icons arrow-l">
                                      arrow_back
                                  </i>
                              </a>
                            Lineas
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('lineas.index')}}">Lineas</a></li>
                            <li class="active">Nueva Linea</li>
                        </ol>
                    </div>
                </div>
                <div class="card stats-card">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <center>
                                        <span class="card-title center-align">
                                            Nueva Linea
                                        </span>
                                        <i class="Small material-icons prefix">
                                            dns
                                        </i>
                                    </center>
                                    <form action="{{ route('lineas.store')}}" method="POST" onsubmit="return checkSubmit()">
                                        @include('lineas.administrador.form', [
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
