@extends('layouts.app')
@section('meta-title', 'Mantenimientos de Equipos ' . 'Tecnoparque ' . \NodoHelper::returnNameNodoUsuario())
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
      	<div class="row no-m-t no-m-b">
        	<div class="col s12 m12 l12">
                <div class="row">
                    <h5 class="left left-align primary-text">
                        <a class="footer-text left-align " href="{{route('equipo.index')}}">
                              <i class="left material-icons primary-text">arrow_back</i>
                        </a> Mantenimientos de Equipos
                    </h5>
                    <div class="right right-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('mantenimiento.index')}}">Mantenimientos</a></li>
                            <li class="active">Nuevo Mantenimiento</li>
                        </ol>
                    </div>
                </div>
          		<div class="card">
            		<div class="card-content">
              			<div class="row">
                            <div class="center-align primary-text">
                                <span class="card-title center-align">Nuevo equipo tecnoparque</span>
                            </div>
                			<div class="divider"></div>
                			<br/>
                        </div>
                        <form id="frmMantenimientoEquipo" action="{{route('mantenimiento.store')}}" method="POST">
                              @include('mantenimiento.form', [
                              'btnText' => 'Registrar'
                              ])
                        </form>
            		</div>
          		</div>
        	</div>
      	</div>
    </div>
</main>
@endsection
