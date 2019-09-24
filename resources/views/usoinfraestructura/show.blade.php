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
                                                	<div class="col s12 m4 l4">
                                                        <div class="center">
                                                            <span class="mailbox-title ">
                                                                Información {{App\Models\UsoInfraestructura::TipoUsoInfraestructura($usoinfraestructura->tipo_usoinfraestructura)}}
                                                            </span>
                                                            
                                                        </div>
                                                        <div class="left">
                                                            <ul class="collection">
                                                                <li class="collection-item ">
                                                                    
                                                                    <p>
                                                                       <strong class="cyan-text text-darken-3"> Código de {{App\Models\UsoInfraestructura::TipoUsoInfraestructura($usoinfraestructura->tipo_usoinfraestructura)}}:</strong>
                                                                        {{$usoinfraestructura->actividad->codigo_actividad}}
                                                                    </p>
                                                                    <p>
                                                                       <strong class="cyan-text text-darken-3">Nombre de {{App\Models\UsoInfraestructura::TipoUsoInfraestructura($usoinfraestructura->tipo_usoinfraestructura)}}:</strong>
                                                                        {{$usoinfraestructura->actividad->nombre}}
                                                                    </p>
                                                                    <p>
                                                                       <strong class="cyan-text text-darken-3">Fecha de Inicio:</strong>
                                                                        {{$usoinfraestructura->actividad->fecha_inicio->isoformat('LL')}}
                                                                    </p>
                                                                    @if(isset($usoinfraestructura->actividad->fecha_cierre) && $usoinfraestructura->actividad->fecha_cierre != null)
                                                                        <p>
                                                                       <strong>Fecha de Inicio :</strong>
                                                                        {{$usoinfraestructura->actividad->fecha_cierre->isoformat('LL')}}
                                                                    </p>
                                                                    @endif
                                                                    @if(isset($usoinfraestructura->actividad->articulacion_proyecto) && $usoinfraestructura->actividad->articulacion_proyecto != null)

                                                                        @if(isset($usoinfraestructura->actividad->articulacion_proyecto->proyecto) && $usoinfraestructura->actividad->articulacion_proyecto->proyecto != null)
                                                                            <p>
                                                                               <strong class="cyan-text text-darken-3">Tipo de {{App\Models\UsoInfraestructura::TipoUsoInfraestructura($usoinfraestructura->tipo_usoinfraestructura)}}:</strong>
                                                                                {{$usoinfraestructura->actividad->articulacion_proyecto->proyecto->tipoproyecto->nombre}}
                                                                            </p>
                                                                            <p>
                                                                               <strong class="cyan-text text-darken-3">Sublinea:</strong>
                                                                                {{$usoinfraestructura->actividad->articulacion_proyecto->proyecto->sublinea->nombre}}
                                                                            </p>
                                                                            <p>
                                                                               <strong class="cyan-text text-darken-3">Sector:</strong>
                                                                                {{$usoinfraestructura->actividad->articulacion_proyecto->proyecto->sector->nombre}}
                                                                            </p>
                                                                            <p>
                                                                               <strong class="cyan-text text-darken-3">Área de Conocimiento:</strong>
                                                                                {{$usoinfraestructura->actividad->articulacion_proyecto->proyecto->areaconocimiento->nombre}}
                                                                            </p>
                                                                            <p>
                                                                               <strong class="cyan-text text-darken-3">Estado del Proyecto:</strong>
                                                                                {{$usoinfraestructura->actividad->articulacion_proyecto->proyecto->estadoproyecto->nombre}}
                                                                            </p>
                                                                        @elseif(isset($usoinfraestructura->actividad->articulacion_proyecto->articulacion) && $usoinfraestructura->actividad->articulacion_proyecto->articulacion != null)
                                                                            <p>
                                                                               <strong class="cyan-text text-darken-3">Tipo Articulación:</strong>
                                                                                {{$usoinfraestructura->actividad->articulacion_proyecto->articulacion->tipoarticulacion->nombre}}
                                                                            </p>
                                                                            
                                                                            @if(isset($usoinfraestructura->actividad->articulacion_proyecto->articulacion->fecha_ejecucion) && $usoinfraestructura->actividad->articulacion_proyecto->articulacion->fecha_ejecucion != null)
                                                                                    <p>
                                                                                   <strong class="cyan-text text-darken-3">Fecha de Ejecucíon :</strong>
                                                                                    {{$usoinfraestructura->actividad->articulacion_proyecto->articulacion->fecha_ejecucion->isoformat('LL')}}
                                                                                </p>
                                                                            @endif
                                                                            
                                                                        <li class="collection-header center">
                                                                            <h6>
                                                                                <b>Talentos asociados a {{App\Models\UsoInfraestructura::TipoUsoInfraestructura($usoinfraestructura->tipo_usoinfraestructura)}} 
                                                                            ({{$usoinfraestructura->actividad->articulacion_proyecto->talentos->count()}})</b>
                                                                        </h6>
                                                                        </li>
                                                                        @forelse($usoinfraestructura->actividad->articulacion_proyecto->talentos as $talento)
                                                                            <li class="collection-item avatar">
                                                                                <i class="material-icons circle teal darken-2">
                                                                                    account_circle
                                                                                </i>
                                                                                <span class="title">
                                                                                   {{$talento->user->documento}} -  {{$talento->user->nombres}} {{$talento->user->apellidos}}
                                                                                </span>
                                                                                   
                                                                            </li>
                                                                        @empty
                                                                        <div class="center">
                                                                           <i class="large material-icons center">
                                                                                block
                                                                            </i>
                                                                            <p class="center-align">No se encontraron resultados</p> 
                                                                        </div>
                                                                        @endforelse
                                                                    @endif

                                                                    @elseif(isset($usoinfraestructura->actividad->edt) && $usoinfraestructura->actividad->edt != null)
                                                                    
                                                                        <p>
                                                                           <strong class="cyan-text text-darken-3">Área de conocimiento:</strong>
                                                                            {{$usoinfraestructura->actividad->edt->areaconocimiento->nombre}}
                                                                        </p>
                                                                        <p>
                                                                           <strong class="cyan-text text-darken-3">Tipo de EDT:</strong>
                                                                            {{$usoinfraestructura->actividad->edt->tipoedt->nombre}}
                                                                        </p>
                                                                        <p>
                                                                           <strong class="cyan-text text-darken-3">Empleados:</strong>
                                                                            {{$usoinfraestructura->actividad->edt->empleados}}
                                                                        </p>
                                                                        <p>
                                                                           <strong class="cyan-text text-darken-3">Instructores:</strong>
                                                                            {{$usoinfraestructura->actividad->edt->instructores}}
                                                                        </p>
                                                                        <p>
                                                                           <strong class="cyan-text text-darken-3">Aprendices:</strong>
                                                                            {{$usoinfraestructura->actividad->edt->aprendices}}
                                                                        </p>
                                                                        <p>
                                                                           <strong class="cyan-text text-darken-3">Público:</strong>
                                                                            {{$usoinfraestructura->actividad->edt->publico}}
                                                                        </p>
                                                                    @endif
                                                                </li>
                                                            </ul>
                                                            @if(isset($usoinfraestructura->actividad->edt) && $usoinfraestructura->actividad->edt != null)
                                                                <div class="center">
                                                                    <span class="mailbox-title ">
                                                                        Empresas ({{$usoinfraestructura->actividad->edt->entidades->count()}})
                                                                    </span>
                                                                    
                                                                </div>
                                                                 <ul class="collection">
                                                                    @forelse($usoinfraestructura->actividad->edt->entidades as $entidad)
                                                                        <li class="collection-item avatar">
                                                                            <i class="material-icons circle teal darken-2">
                                                                                business_center
                                                                            </i>
                                                                            <span class="title">
                                                                               {{$entidad->empresa->nit}} - {{$entidad->nombre}}
                                                                            </span>
                                                                            <p>
                                                                               {{$entidad->ciudad->nombre}} ({{$entidad->ciudad->departamento->nombre}})
                                                                            </p>
                                                                            <p>
                                                                               {{$entidad->email_entidad}}
                                                                            </p>
                                                                            <p>
                                                                               {{$entidad->empresa->direccion}}
                                                                            </p>
                                                                            
                                                                        </li>
                                                                    @empty
                                                                    <div class="center">
                                                                       <i class="large material-icons center">
                                                                            block
                                                                        </i>
                                                                        <p class="center-align">No se encontraron resultados</p> 
                                                                    </div>
                                                                    @endforelse
                                                                    
                                                                </ul>
                                                            @endif
                                                        </div>
                                                        <div class="divider mailbox-divider"></div>
                                                    </div>
                                                    <div class="col s12 m8 l8">
                                                        <div class="center">
                                                            <span class="mailbox-title ">
                                                                Información Uso Infraestructura
                                                            </span>
                                                            
                                                        </div>
                                                        <div class="divider mailbox-divider"></div>
                                                        <div class="row">
                                                            <div class="col s12 m12 l12">
                                                                <ul class="collection">
                                                                    <li class="collection-item avatar">
                                                                        <i class="material-icons circle teal darken-2">
                                                                            date_range
                                                                        </i>
                                                                        <span class="title">
                                                                           Fecha
                                                                        </span>
                                                                        <p>
                                                                           {{$usoinfraestructura->fecha->isoformat('LL')}}
                                                                        </p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col s12 m6 l6">
                                                                <ul class="collection">
                                                                    <li class="collection-item avatar">
                                                                        <i class="material-icons circle teal darken-2">
                                                                             book
                                                                        </i>
                                                                        <span class="title">
                                                                           Asesoria Directa
                                                                        </span>
                                                                        <p>
                                                                       {{isset($usoinfraestructura->asesoria_directa) ? $usoinfraestructura->asesoria_directa.' horas' : 'No registra' }}
                                                                        </p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col s12 m6 l6">
                                                                <ul class="collection">
                                                                    <li class="collection-item avatar">
                                                                        <i class="material-icons circle teal darken-2">
                                                                            bookmark
                                                                        </i>
                                                                        <span class="title">
                                                                           Asesoria Indirecta
                                                                        </span>
                                                                        <p>
                                                                           {{isset($usoinfraestructura->asesoria_indirecta) ? $usoinfraestructura->asesoria_indirecta.' horas' : 'No registra'}}
                                                                        </p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col s12 m12 l12">
                                                                <ul class="collection">
                                                                    <li class="collection-item avatar">
                                                                        <i class="material-icons circle teal darken-2">
                                                                            create
                                                                        </i>
                                                                        <span class="title">
                                                                           Descripción
                                                                        </span>
                                                                        <p>
                                                                           {{isset($usoinfraestructura->descripcion) && $usoinfraestructura->descripcion != '' ? $usoinfraestructura->descripcion : 'No registra'}}
                                                                        </p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col s12 m6 l6">
                                                                <div class="center">
                                                                    <span class="mailbox-title ">
                                                                        Talentos ({{$usoinfraestructura->usotalentos->count()}})
                                                                    </span> 
                                                                </div>
                                                                <div class="divider mailbox-divider"></div>
                                                                <ul class="collection">
                                                                    @forelse($usoinfraestructura->usotalentos as $usotal)
                                                                        <li class="collection-item avatar">
                                                                            <i class="material-icons circle teal darken-2">
                                                                                account_circle
                                                                            </i>
                                                                            <span class="title">
                                                                               {{$usotal->user->documento}} - {{$usotal->user->nombres}} {{$usotal->user->apellidos}}
                                                                            </span>
                                                                        </li>
                                                                    @empty
                                                                    <div class="center">
                                                                       <i class="large material-icons center">
                                                                            block
                                                                        </i>
                                                                        <p class="center-align">No se encontraron resultados</p> 
                                                                    </div>
                                                                    @endforelse
                                                                    
                                                                </ul>
                                                            </div>
                                                            <div class="col s12 m6 l6">
                                                                <div class="center">
                                                                    <span class="mailbox-title ">
                                                                        Laboratorios ({{$usoinfraestructura->usolaboratorios->count()}})
                                                                    </span> 
                                                                </div>
                                                                <div class="divider mailbox-divider"></div>
                                                                <ul class="collection">
                                                                    @forelse($usoinfraestructura->usolaboratorios as $usolab)
                                                                        <li class="collection-item avatar">
                                                                            <i class="material-icons circle teal darken-2">
                                                                                local_drink
                                                                            </i>
                                                                            <span class="title">
                                                                               <strong class="cyan-text text-darken-3">Laboratorio:</strong> {{$usolab->nombre}} 
                                                                            </span>
                                                                            <p>
                                                                               <strong class="cyan-text text-darken-3">Tiempo Uso:</strong> {{$usolab->pivot->tiempo}} horas 
                                                                            </p>   
                                                                        </li>
                                                                    @empty
                                                                    <div class="center">
                                                                       <i class="large material-icons center">
                                                                            block
                                                                        </i>
                                                                        <p class="center-align">No se encontraron resultados</p> 
                                                                    </div>
                                                                    @endforelse
                                                                    
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="right">
                                                            <a href="{{route('usoinfraestructura.index')}}" class="btn waves-effect cyan darken-2 center-aling"><i class="material-icons right">
                                                                    arrow_back
                                                                </i>
                                                                volver
                                                            </a>
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
	    </div>
	</main>
@endsection