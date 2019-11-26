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
                                                                       <strong class="cyan-text text-darken-3">Fecha de Cierre :</strong>
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
                                                                    <li class="collection-item ">
                                                                        
                                                                        <span class="title cyan-text text-darken-3">
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
                                                                    <li class="collection-item ">
                                                        
                                                                        <span class="title cyan-text text-darken-3">
                                                                           Asesoria Directa 
                                                                        </span>
                                                                        <p>
                                                                            {{$usoinfraestructura->usogestores->sum('pivot.asesoria_directa')}}
                                                                       
                                                                        </p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col s12 m6 l6">
                                                                <ul class="collection">
                                                                    <li class="collection-item ">
                                                                        <span class="title cyan-text text-darken-3">
                                                                           Asesoria Indirecta
                                                                        </span>
                                                                        <p>
                                                                            {{$usoinfraestructura->usogestores->sum('pivot.asesoria_indirecta')}}
                                                                       
                                                                        </p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col s12 m12 l12">
                                                                <ul class="collection">
                                                                    <li class="collection-item ">
                                                                    
                                                                        <span class="title cyan-text text-darken-3">
                                                                           Descripción
                                                                        </span>
                                                                        <p>
                                                                           {{isset($usoinfraestructura->descripcion) && $usoinfraestructura->descripcion != '' ? $usoinfraestructura->descripcion : 'No registra'}}
                                                                        </p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        {{-- @if ($usoinfraestructura->usogestores->isEmpty()) --}}
                                                            <div class="row">
                                                                <div class="col s12 m6 l6 offset-l3 m3">
                                                                    <div class="center">
                                                                        <span class="mailbox-title ">
                                                                            Asesores ({{$usoinfraestructura->usogestores->count()}})
                                                                        </span> 
                                                                    </div>
                                                                    <div class="divider mailbox-divider"></div>
                                                                    <ul class="collection">
                                                                        
                                                                        
                                                                            @forelse ($usoinfraestructura->usogestores as $usogestor) 
                                                                            <li class="collection-item ">
                                                                                <span class="title cyan-text text-darken-3">
                                                                                    {{$usogestor->user->documento}} - {{$usogestor->user->nombres}} {{$usogestor->user->apellidos}}
                                                                                </span>
                                                                                @if ($usogestor->pivot->asesoria_directa == 1) 
                                                                                    <p class="title">
                                                                                        <strong class="cyan-text text-darken-3">Horas Asesoria Directa: </strong>{{$usogestor->pivot->asesoria_directa}}  hora
                                                                                    </p>
                                                                                @elseif($usogestor->pivot->asesoria_directa == 0)
                                                                                    <strong class="cyan-text text-darken-3">Horas Asesoria Directa: </strong>No registra
                                                                                @else
                                                                                    <p class="title">
                                                                                         <strong class="cyan-text text-darken-3">Horas Asesoria Directa: </strong>{{$usogestor->pivot->asesoria_directa}}  horas
                                                                                    </p> 
                                                                                @endif
                                                                                @if ($usogestor->pivot->asesoria_indirecta == 1) 
                                                                                    <p class="title">
                                                                                        <strong class="cyan-text text-darken-3">Horas Asesoria Indirecta: </strong>{{$usogestor->pivot->asesoria_indirecta}}  hora
                                                                                    </p>
                                                                                @elseif($usogestor->pivot->asesoria_indirecta == 0)
                                                                                    <strong class="cyan-text text-darken-3">Horas Asesoria Indirecta: </strong>No registra
                                                                                @else
                                                                                    <p class="title">
                                                                                         <strong class="cyan-text text-darken-3">Horas Asesoria Directa: </strong>{{$usogestor->pivot->asesoria_indirecta}}  horas
                                                                                    </p> 
                                                                                @endif
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
                                                        {{-- @endif --}}
                                                        <div class="row">
                                                            <div class="col s12 m6 l6 offset-l3 m3">
                                                                <div class="center">
                                                                    <span class="mailbox-title ">
                                                                        Talentos ({{$usoinfraestructura->usotalentos->count()}})
                                                                    </span> 
                                                                </div>
                                                                <div class="divider mailbox-divider"></div>
                                                                <ul class="collection">
                                                                    @forelse($usoinfraestructura->usotalentos as $usotal)
                                                                        <li class="collection-item ">
                                                                            
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
                                                        </div>
                                                        <div class="divider"></div>
                                                        <div class="row">
                                                            <div class="col s12 m6 l6">
                                                                <div class="center">
                                                                    <span class="mailbox-title ">
                                                                        Equipos ({{$usoinfraestructura->usoequipos->count()}})
                                                                    </span> 
                                                                </div>
                                                                <div class="divider mailbox-divider"></div>
                                                                <ul class="collection">
                                                                    @forelse($usoinfraestructura->usoequipos as $usoequipo)
                                                                        <li class="collection-item ">
                                                                            
                                                                            <span class="cyan-text text-darken-3">
                                                                               Nombre: 
                                                                            </span>
                                                                            {{$usoequipo->nombre}}
                                                                            <p class="cyan-text text-darken-3">
                                                                                Referencia: 
                                                                            </p>
                                                                            {{$usoequipo->referencia}}
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
                                                                        Materiales de Formación ({{$usoinfraestructura->usomateriales->count()}})
                                                                    </span> 
                                                                </div>
                                                                <div class="divider mailbox-divider"></div>
                                                                <ul class="collection">
                                                                    @forelse($usoinfraestructura->usomateriales as $usomaterial)
                                                                        <li class="collection-item ">
                                                                            
                                                                            <span class="title">
                                                                               <strong class="cyan-text text-darken-3">Material:</strong> {{$usomaterial->codigo_material}} {{$usomaterial->nombre}} 
                                                                            </span>
                                                                            <p>
                                                                               <strong class="cyan-text text-darken-3">Cantidad:</strong> {{$usomaterial->pivot->unidad}}  
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