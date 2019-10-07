@extends('layouts.app')
@section('meta-title', 'Equipos ' . 'Tecnoparque Nodo ' . \NodoHelper::returnNameNodoUsuario())
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
      	<div class="row no-m-t no-m-b">
        	<div class="col s12 m12 l12">
        		<div class="row">
                    <div class="col s8 m8 l9">
                        <h5 class="left-align">
                            <a class="footer-text left-align" href="{{route('equipo.index')}}">
				              	<i class="material-icons arrow-l">arrow_back</i>
				            </a> Equipos Tecnoparque Nodo  {{\NodoHelper::returnNameNodoUsuario()}}
                        </h5>
                    </div>
                    <div class="col s4 m4 l3 rigth-align">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('equipo.index')}}">Equipos</a></li>
                            <li class="active">Editar Equipo</li>
                        </ol>
                    </div>
                </div>
          		<div class="card">
            		<div class="card-content">
              			<div class="row">
			                <center>
				                <span class="card-title center-align">Editar Equipo <b>{{$equipo->nombre}}</b>  | Tecnoparque Nodo {{ \NodoHelper::returnNameNodoUsuario() }}
				                </span>
			                </center>
                			<div class="divider"></div>
                			<br/>
                			<form  action="{{route('equipo.update',$equipo->id)}}" method="POST" onsubmit="return checkSubmit()">
			                  	{!! method_field('PUT')!!}
			                  	@include('equipo.form', [
			                  	'btnText' => 'Modificar'
			                  	])
                			</form>
              			</div>
            		</div>
          		</div>
        	</div>
      	</div>
    </div>
</main>
@endsection
