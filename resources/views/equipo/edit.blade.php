@extends('layouts.app')
@section('meta-title', 'Equipos ' . 'Tecnoparque ' . \NodoHelper::returnNameNodoUsuario())
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
      	<div class="row">
        	<div class="col s12 m12 l12">
        		<div class="row no-m-t no-m-b m-r-lg m-l-lg">
                    <h5 class="left left-align primary-text">
                        <a href="{{route('equipo.index')}}">
                              <i class="material-icons arrow-l left primary-text">arrow_back</i>
                        </a> Equipos
                    </h5>
                    <div class="right right-align">
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
                            <div class="col s12 m12 l12">
                                <div class="center-align primary-text">
                                    <span class="card-title center-align">Editar Equipo <b> Tecnoparque {{$equipo->nodo->entidad->nombre}} 
                                </div>
                            </div>
                			<div class="divider"></div>
                			<br/>
                            @if( $lineastecnologicas->count() == 0)
                                <div class="center-align">
                                    <i class="large material-icons prefix">
                                        block
                                    </i>
                                    <p>
                                        Para registrar un nuevo equipo, el tecnoparque debe tener lineas asociadas, por favor solicita al administrador de la plataforma para que este agregue nuevas lineas tecnológicas al nodo.
                                    </p>
                                </div>
                            @else
                    			<form action="{{route('equipo.update',$equipo->id)}}" method="POST" onsubmit="return checkSubmit()">
    			                  	{!! method_field('PUT')!!}
    			                  	@include('equipo.form', [
    			                  	'btnText' => 'Modificar'
    			                  	])
                    			</form>
                            @endif
              			</div>
            		</div>
          		</div>
        	</div>
      	</div>
    </div>
</main>
@endsection
