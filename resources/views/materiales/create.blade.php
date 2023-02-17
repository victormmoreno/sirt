@extends('layouts.app')
@section('meta-title', 'Materiales')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
      	<div class="row no-m-t no-m-b">
        	<div class="col s12 m12 l12">
        		<div class="row">
                    <h5 class="left left-align primary-text">
                        <a class="footer-text " href="{{route('equipo.index')}}">
                              <i class="material-icons primary-text">local_library</i>
                        </a> Materiales de Formación Tecnoparque
                    </h5>
                    <div class="right right-align rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('equipo.index')}}">Materiales</a></li>
                            <li class="active">Nuevo Material</li>
                        </ol>
                    </div>
                </div>
          		<div class="card">
            		<div class="card-content">
              			<div class="row">
			                <center>
				                <span class="card-title center-align primary-text">Nuevo Material Tecnoparque Nodo {{ \NodoHelper::returnNameNodoUsuario() }}
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
                    			<form  action="{{route('material.store')}}" method="POST" onsubmit="return checkSubmit()">
    			                  	@include('materiales.form', [
    			                  	'btnText' => 'Registrar'
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
@push('script')
<script>
    $(document).ready(function() {
        @if($errors->any() && session()->get('login_role') == App\User::IsAdministrador())
            consultarLineasNodo({{old('txtnodo_id')}});
        @endif
    });
</script>
@endpush
