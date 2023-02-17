@extends('layouts.app')
@section('meta-title', 'Costos Administrativos | ' . $costoadministrativo->costoadministrativo)
@section('meta-content', 'Costos Administrativos')
@section('meta-keywords', 'Costos Administrativos')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <a class="footer-text left-align" href="{{route('costoadministrativo.index')}}">
                        <i class="material-icons left">arrow_back</i>
                    </a>
                    Editar Costos Administrativos Tecnoparque nodo {{$costoadministrativo->entidad}}
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li><a href="{{route('costoadministrativo.index')}}">Costos Administrativos</a></li>
                    <li class="active">Editar Costo</li>
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
                                    <span class="card-title center-align primary-text">Editar Costo Administrativo <b>{{$costoadministrativo->costoadministrativo}} - {{$costoadministrativo->anho}}</b></span>
                                </div>
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
