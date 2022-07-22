@extends('layouts.app')

@section('meta-title', 'Costo Administrativo | ' . $costoadministrativo->costoadministrativo)
@section('meta-content', 'Costo Administrativo')
@section('meta-keywords', 'Costo Administrativo')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align">
                            <a class="footer-text left-align" href="{{route('costoadministrativo.index')}}">
                                  <i class="material-icons arrow-l">
                                      arrow_back
                                  </i>
                              </a>
                            Costos Administrativos Tecnoparque Nodo {{\NodoHelper::returnNameNodoUsuario()}}
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('costoadministrativo.index')}}">Costo</a></li>
                            <li class="active">Editar Costo</li>
                        </ol>
                    </div>
                </div>
                <div class="card stats-card">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <center><span class="card-title center-align">Editar Costo Administrativo <b>{{$costoadministrativo->costoadministrativo}} - {{$costoadministrativo->anho}}</b></span> <i class="Small material-icons prefix">settings_input_svideo </i></center>
                                <form action="{{ route('costoadministrativo.update', [$costoadministrativo->id, $nodo])}}" method="POST" onsubmit="return checkSubmit()">
                                	{!! method_field('PUT')!!}
	                                @include('costoadministrativo.form', [
								    	'btnText' => 'Modificar',
								   	])
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