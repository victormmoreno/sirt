@extends('layouts.app')
@section('meta-title', 'Materiales ')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
      	<div class="row no-m-t no-m-b">
        	<div class="col s12 m12 l12">
        		<div class="row">
                    <div class="col s8 m8 l9">
                        <h5 class="left-align ">
                            <a class="footer-text left-align " href="{{route('equipo.index')}}">
				              	<i class="material-icons">local_library</i>
				            </a> Materiales de Formación Tecnoparque Nodo  {{\NodoHelper::returnNameNodoUsuario()}}
                        </h5>
                    </div>
                    <div class="col s4 m4 l3 rigth-align">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('equipo.index')}}">Materiales</a></li>
                            <li class="active">Editar Material</li>
                        </ol>
                    </div>
                </div>
          		<div class="card">
                
                    
            		<div class="card-content">
              			<div class="row">
			                <center>
				                <span class="card-title center-align">Editar Material <strong>{{$material->codigo_material}} - {{$material->nombre}}</strong> | Tecnoparque Nodo {{ \NodoHelper::returnNameNodoUsuario() }}
				                </span>
			                </center>
                			<div class="divider"></div>
                			<br/>
                            @if( $lineastecnologicas->count() == 0)
                                
                                <div class="center-align">
                                    <i class="large material-icons prefix">
                                        block
                                    </i>
                                    
                                    <p>
                                        Para registrar un nuevo material, Tecnoparque Nodo {{ \NodoHelper::returnNameNodoUsuario() }} debe tener lineas asociadas, por favor solicita al administrador de la plataforma para que este agregue nuevas lineas tecnológicas al nodo.
                                    </p>
                                    
                                    
                                </div>
                            @else
                    			<form  action="{{route('material.update', $material->id)}}" method="POST" onsubmit="return checkSubmit()">
                                    {!! method_field('PUT')!!}
    			                  	@include('materiales.form', [
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
