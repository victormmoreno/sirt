@extends('layouts.app')
@section('meta-title', 'Uso Infraestructura')

@section('content')
	<main class="mn-inner inner-active-sidebar">
	    <div class="content">
	        <div class="row no-m-t no-m-b">
	            <div class="col s12 m12 l12">
	                <div class="row">
	                    <div class="col s12 m6 l6">
	                        <h5 class="left-align">
	                            
	                            Uso Infraestructura 
	                        </h5>
	                    </div>
	                    <div class="col s12 m4 l4 offset-l2 m-2 rigth-align">
	                        <ol class="breadcrumbs">
	                            <li><a href="{{route('home')}}">Inicio</a></li>
	                            <li><a href="{{route('usoinfraestructura.index')}}">Uso Infraestructura </a></li>
	                            <li class="active">Uso Infraestructura </li>
	                        </ol>
	                    </div>
	                </div>
	                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card mailbox-content">
                            <div class="card-content">
                            	<div class="row no-m-t no-m-b">
                                    
                                    <div class="col s12 m12 l12">
                                        
                                        <div class="mailbox-view">
                                            <div class="mailbox-view-header">
                                            	<div class="left">
                                                    <div class="left">
                                                        <i class="material-icons left">
                                                            location_city
                                                        </i>
                                                    </div>
                                                    <div class="left">
                                                        <span class="mailbox-title">
	                                                        Uso Infraestructura | {{$usoinfraestructura->actividad->codigo_actividad}} - {{$usoinfraestructura->actividad->nombre}}
	                                                    </span>
	                                                    <span class="mailbox-author">
	                                                        <b>Nodo: </b> Tecnoparque nodo {{$usoinfraestructura->actividad->nodo->entidad->nombre}}, {{$usoinfraestructura->actividad->nodo->entidad->ciudad->nombre}} ({{$usoinfraestructura->actividad->nodo->entidad->ciudad->departamento->nombre}})<br/>
	                                                        <b>Linea Tecnológica: </b> {{isset($usoinfraestructura->actividad->gestor->lineatecnologica->nombre) ? $usoinfraestructura->actividad->gestor->lineatecnologica->nombre : 'No registra'}} <br/>
	                                                       
	                                                        <b>Gestor Asesor: </b> 
	                                                        {{$usoinfraestructura->actividad->gestor->user->documento}} - {{$usoinfraestructura->actividad->gestor->user->nombres}} {{$usoinfraestructura->actividad->gestor->user->apellidos}}<br/>
	                                                    </span>
                                                    </div>
                                                    
                                                </div>
                                                <div class="right mailbox-buttons">
                                                        <span class="mailbox-title">
                                                            <p class="center">Información Uso Infraestructura</p><br/>
                                                            
                                                        </span>
                                                    </div> 
                                                
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="mailbox-text">
                                                <div class="row">
                                                	<div class="col s12 m4 l4  {{-- push-l1 push-m1 --}}">
                                                        <div class="center">
                                                            <span class="mailbox-title">
                                                                Información 
                                                            </span>
                                                        </div>
                                                        <div class="divider mailbox-divider"></div>
                                                        
                                                        <div class="divider mailbox-divider"></div>
                                                        <div class="center">
                                                            <span class="mailbox-title">
                                                                Laboratorios {{-- ({{$nodo->laboratorios->count()}}) --}}
                                                            </span>
                                                        </div>
                                                       {{--  <ul class="collection">
                                                            @forelse($nodo->laboratorios as $laboratorios)
                                                                <li class="collection-item avatar">
                                                                    <i class="material-icons circle teal darken-2">
                                                                        local_drink
                                                                    </i>
                                                                    <span class="title">
                                                                        {{$laboratorios->nombre}}
                                                                    </span>
                                                                    <p>
                                                                       {{$laboratorios->lineatecnologica->abreviatura}} -  {{$laboratorios->lineatecnologica->nombre}}
                                                                        
                                                                    </p>
                                                                </li>
                                                            @empty
                                                            <div class="center">
                                                               <i class="large material-icons center">
                                                                    block
                                                                </i>
                                                                <p class="center-align">Tecnoparque Nodo {{$nodo->entidad->nombre}} no tiene laboratorios aún</p> 
                                                            </div>
                                                            @endforelse
                                                            
                                                        </ul> --}}
                                                        <div class="divider mailbox-divider"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
	            </div>
	        </div>
	    </div>
	</main>
@endsection