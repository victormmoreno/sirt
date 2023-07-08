@extends('layouts.app')
@section('meta-title', 'Materiales')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
      	<div class="row no-m-t no-m-b">
        	<div class="col s12 m12 l12">
        		<div class="row">
                    <h5 class="left left-align primary-text">
                        <a class="footer-text" href="{{route('equipo.index')}}">
                              <i class="material-icons left primary-text">local_library</i>
                        </a> Materiales de Formación Tecnoparque {{$material->nodo->entidad->nombre}}
                    </h5>
                    <div class="right right-align show-on-large hide-on-med-and-down">
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
			                <div class="center">
				                <span class="card-title center-align primary-text">Editar Material <strong>{{$material->codigo_material}} - {{$material->nombre}}</strong>
				                </span>
			                </div>
                			<div class="divider"></div>
                			<br/>
                            @if( $lineastecnologicas->count() == 0)
                                <div class="center-align">
                                    <i class="large material-icons prefix">
                                        block
                                    </i>
                                    
                                    <p>
                                        Para editar un nuevo material, Tecnoparque {{ \NodoHelper::returnNameNodoUsuario() }} debe tener lineas asociadas, por favor solicita al administrador de la plataforma para que este agregue nuevas lineas tecnológicas al nodo.
                                    </p>
                                </div>
                            @else
                    			<form  action="{{route('material.update', $material->id)}}" method="POST" onsubmit="return checkSubmit()">
                                    {!! method_field('PUT')!!}
    			                  	@include('materiales.form', [
    			                  	'btnText' => 'Guardar Cambios'
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
