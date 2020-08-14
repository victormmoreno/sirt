@extends('layouts.app')
@section('meta-title', 'Equipos ' . 'Tecnoparque Nodo ' . \NodoHelper::returnNameNodoUsuario())
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
      	<div class="row no-m-t no-m-b">
        	<div class="col s12 m12 l12">
        		<div class="row">
                    <div class="col s8 m8 l9">
                        <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                            <a class="footer-text left-align " href="{{route('equipo.index')}}">
				              	<i class="fas fa-box"></i>
				            </a> Equipos
                        </h5>
                    </div>
                    <div class="col s4 m4 l3 rigth-align">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('equipo.index')}}">Equipos</a></li>
                            <li class="active">Nuevo Equipo</li>
                        </ol>
                    </div>
                </div>
          		<div class="card">
            		<div class="card-content">
              			<div class="row">
                            <div class="col s12 m12 l12">
                                <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
                                    <span class="card-title center-align">Nuevo Equipo Tecnoparque Nodo {{ \NodoHelper::returnNameNodoUsuario() }}</span>
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
                                        Para registrar un nuevo equipo, Tecnoparque Nodo {{ \NodoHelper::returnNameNodoUsuario() }} debe tener lineas asociadas, por favor solicita al administrador de la plataforma para que este agregue nuevas lineas tecnológicas al nodo.
                                    </p>
                                </div>
                            @else
                    			<form  action="{{route('equipo.store')}}" method="POST" onsubmit="return checkSubmit()">
    			                  	@include('equipo.form', [
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
