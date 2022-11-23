@extends('layouts.app')
@section('meta-title', 'Editar Linea Tecnologica' . $linea->nombre)
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <a class="footer-text left-align" href="{{route('lineas.index')}}">
                        <i class="material-icons arrow-l">arrow_back</i>
                    </a>Líneas
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li><a href="{{route('lineas.index')}}">Líneas</a></li>
                    <li class="active">Editar Línea</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="card stats-card">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <div class="center-align">
                                    <span class="card-title center-align primary-text">Editar Linea <b>{{$linea->nombre}}</b></span>
                                </div>
                                <div class="divider"></div>
                                <form action="{{ route('lineas.update', $linea->id)}}" method="POST" onsubmit="return checkSubmit()">
                                	{!! method_field('PUT')!!}
	                                @include('lineas.form', [
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
