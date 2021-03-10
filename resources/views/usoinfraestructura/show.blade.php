@extends('layouts.app')
@section('meta-title', 'Asesoría y uso')

@section('content')
	<main class="mn-inner inner-active-sidebar">
	    <div class="content">
	        <div class="row no-m-t no-m-b">
	            <div class="col s12 m12 l12">
	                <div class="row">
	                    <div class="col s12 m8 l8">
	                        <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
	                            <a class="footer-text left-align" href="{{route('usoinfraestructura.index')}}">
                                    <i class="material-icons arrow-l">
                                        arrow_back
                                    </i>
                                </a>
	                            Asesoría y uso
	                        </h5>
	                    </div>
	                    <div class="col s12 m4 l4 ">
	                        <ol class="breadcrumbs">
	                            <li><a href="{{route('home')}}">Inicio</a></li>
	                            <li><a href="{{route('usoinfraestructura.index')}}">Asesoría y uso</a></li>
	                            <li class="active">Asesoría y uso </li>
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
                                                        <i class="material-icons left orange-text text-darken-3">
                                                            location_city
                                                        </i>
                                                    </div>
                                                    <div class="left">
                                                        <span class="mailbox-title orange-text text-darken-3">
	                                                        Asesoría y uso | {{$usoinfraestructura->actividad->codigo_actividad}} - {{$usoinfraestructura->actividad->nombre}}
	                                                    </span>
	                                                    <span class="mailbox-author">
	                                                        <b>Nodo: </b> Tecnoparque nodo {{$usoinfraestructura->actividad->nodo->entidad->nombre}}, {{$usoinfraestructura->actividad->nodo->entidad->ciudad->nombre}} ({{$usoinfraestructura->actividad->nodo->entidad->ciudad->departamento->nombre}})<br/>
	                                                        <b>Linea Tecnológica: </b> {{isset($usoinfraestructura->actividad->gestor->lineatecnologica->nombre) ? $usoinfraestructura->actividad->gestor->lineatecnologica->nombre : 'No registra'}} <br/>
	                                                        <b>Gestor Asesor: </b>
	                                                        {{$usoinfraestructura->actividad->gestor->user()->withTrashed()->first()->documento}} - {{$usoinfraestructura->actividad->gestor->user()->withTrashed()->first()->nombres}} {{$usoinfraestructura->actividad->gestor->user()->withTrashed()->first()->apellidos}}<br/>
	                                                    </span>
                                                    </div>
                                                </div>
                                                @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsGestor() || session()->get('login_role') == App\User::IsTalento()))
                                                <div class="right mailbox-buttons">
                                                    <span class="mailbox-title">

                                                        <p class="center">
                                                            Información Asesoría y uso
                                                                <div class="right">
                                                                    <a class="waves-effect waves-light btn m-t-xs dropdown-button " data-activates="actifiad" href="#">
                                                                        <i class="material-icons right">
                                                                            more_vert
                                                                        </i>
                                                                        Más Información
                                                                    </a>
                                                                    <!-- Dropdown Structure -->
                                                                    <ul class="dropdown-content" id="actifiad">
                                                                        <li>
                                                                        <a href="{{route('usoinfraestructura.edit',$usoinfraestructura->id)}}">
                                                                                Cambiar Información
                                                                            </a>
                                                                        </li>

                                                                    </ul>
                                                            </div>
                                                        </p>
                                                    </span>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="divider mailbox-divider">
                                            </div>
                                            <div class="mailbox-text">
                                                <div class="row">
                                                    <div class="col s12 m4 l4">
                                                        <div class="center">
                                                            <span class="mailbox-title green-complement-text">
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
                                                                                {{isset($usoinfraestructura->actividad->articulacion_proyecto->proyecto->tipoproyecto) ? $usoinfraestructura->actividad->articulacion_proyecto->proyecto->tipoproyecto->nombre : 'No registra'}}
                                                                            </p>
                                                                            <p>
                                                                               <strong class="cyan-text text-darken-3">Sublinea:</strong>
                                                                                {{$usoinfraestructura->actividad->articulacion_proyecto->proyecto->sublinea->nombre}}
                                                                            </p>
                                                                            <p>
                                                                               <strong class="cyan-text text-darken-3">Sector:</strong>
                                                                                {{isset($usoinfraestructura->actividad->articulacion_proyecto->proyecto->sector) ? $usoinfraestructura->actividad->articulacion_proyecto->proyecto->sector->nombre : 'No registra'}}
                                                                            </p>
                                                                            <p>
                                                                               <strong class="cyan-text text-darken-3">Área de Conocimiento:</strong>
                                                                                {{$usoinfraestructura->actividad->articulacion_proyecto->proyecto->areaconocimiento->nombre}}
                                                                            </p>
                                                                            <p>
                                                                                <strong class="cyan-text text-darken-3">Fase del Proyecto:</strong>
                                                                                {{isset($usoinfraestructura->actividad->articulacion_proyecto->proyecto->fase) ? $usoinfraestructura->actividad->articulacion_proyecto->proyecto->fase->nombre : 'No registra' }}
                                                                            </p>
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
                                                        <ul class="collection">
                                                            <li class="collection-item ">
                                                                <p class="title">
                                                                    <strong class="cyan-text text-darken-3">Costos de Asesoria: </strong>$ {{number_format($usoinfraestructura->usogestores->sum('pivot.costo_asesoria'),0)}}
                                                                </p>
                                                            </li>
                                                            @if(isset($usoinfraestructura->usoequipos))
                                                                <li class="collection-item ">
                                                                    <p class="title">
                                                                        <strong class="cyan-text text-darken-3">Costos de Equipos: </strong>$ {{number_format($usoinfraestructura->usoequipos->sum('pivot.costo_equipo'),0)}}
                                                                    </p>
                                                                    <p class="title">
                                                                        <strong class="cyan-text text-darken-3">Costos Administrativos: </strong>$ {{number_format($usoinfraestructura->usoequipos->sum('pivot.costo_administrativo'),0)}}
                                                                    </p>
                                                                </li>
                                                            @endif
                                                            @if(isset($usoinfraestructura->usomateriales))
                                                                <li class="collection-item ">
                                                                    <p class="title">
                                                                        <strong class="cyan-text text-darken-3">Costos de Materiales de formación: </strong>$ {{number_format($usoinfraestructura->usomateriales->sum('pivot.costo_material'),0)}}
                                                                    </p>
                                                                </li>
                                                            @endif
                                                            <li class="collection-item ">
                                                                <p class="title">
                                                                    <strong class="cyan-text text-darken-3">Total Costos: </strong>$ {{number_format($totalCostos,0)}}
                                                                </p>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                    <div class="col s12 m8 l8">
                                                        <div class="center">
                                                            <span class="mailbox-title green-complement-text">
                                                                Información Asesoría y uso
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
                                                        <div class="row">
                                                            <div class="col s12 m12 l12">
                                                                <ul class="collection">
                                                                    <li class="collection-item ">
                                                                        <span class="title cyan-text text-darken-3">
                                                                            Próximos compromisos
                                                                        </span>
                                                                        <p>
                                                                            {{isset($usoinfraestructura->compromisos) && $usoinfraestructura->compromisos != '' ? $usoinfraestructura->descripcion : 'No registra'}}
                                                                        </p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col s12 m6 l6 offset-l3 m3">
                                                                <div class="center">
                                                                    <span class="mailbox-title green-complement-text">
                                                                        Asesores ({{$usoinfraestructura->usogestores->count()}})
                                                                    </span>
                                                                </div>
                                                                <div class="divider mailbox-divider"></div>
                                                                <ul class="collection">
                                                                    @forelse ($usoinfraestructura->usogestores as $usogestor)
                                                                    <li class="collection-item ">
                                                                        @if(isset( $usogestor))

                                                                        <p class="title">
                                                                            <strong class="cyan-text text-darken-3">Asesor: </strong>{{$usogestor->user()->withTrashed()->first()->documento}} - {{$usogestor->user()->withTrashed()->first()->nombres}} {{$usogestor->user()->withTrashed()->first()->apellidos}}
                                                                        </p>
                                                                        @endif
                                                                        @if ($usogestor->pivot->asesoria_directa == 1)
                                                                            <p class="title">
                                                                                <strong class="cyan-text text-darken-3">Horas Asesoria Directa: </strong>{{$usogestor->pivot->asesoria_directa}}  hora
                                                                            </p>
                                                                        @elseif($usogestor->pivot->asesoria_directa == 0)
                                                                            <p class="title">
                                                                                <strong class="cyan-text text-darken-3">Horas Asesoria Directa: </strong>No registra
                                                                            </p>
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
                                                        <div class="row">
                                                            <div class="col s12 m6 l6 offset-l3 m3">
                                                                <div class="center">
                                                                    <span class="mailbox-title green-complement-text">
                                                                        Talentos ({{$usoinfraestructura->usotalentos->count()}})
                                                                    </span>
                                                                </div>
                                                                <div class="divider mailbox-divider"></div>
                                                                <ul class="collection">
                                                                    @forelse($usoinfraestructura->usotalentos as $usotal)
                                                                        <li class="collection-item ">
                                                                            <span class="title">
                                                                                {{$usotal->user()->withTrashed()->first()->documento}} - {{$usotal->user()->withTrashed()->first()->nombres}} {{$usotal->user()->withTrashed()->first()->apellidos}}
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
                                                                    <span class="mailbox-title green-complement-text">
                                                                        Equipos ({{$equipos->count()}})
                                                                        
                                                                    </span>
                                                                </div>
                                                                <div class="divider mailbox-divider"></div>
                                                                <ul class="collection">
                                                                    @forelse($equipos as $equipo)
                                                                        <li class="collection-item ">
                                                                            <p class="title">
                                                                                <strong class="cyan-text text-darken-3">Nombre: </strong>{{$equipo->nombre}}
                                                                            </p>
                                                                            <p class="title">
                                                                                <strong class="cyan-text text-darken-3">Referencia: </strong>{{$equipo->referencia}}
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
                                                            <div class="col s12 m6 l6">
                                                                <div class="center">
                                                                    <span class="mailbox-title green-complement-text">
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
                                                            <a href="{{route('usoinfraestructura.edit',$usoinfraestructura->id)}}" class="waves-effect waves-teal darken-2 btn-flat m-t-xs center-aling">
                                                                Cambiar Información
                                                            </a>
                                                            <a href="javascript:void(0)"  class="waves-effect red lighten-3 btn 2 btn-flat m-t-xs center-aling" onclick="usoinfraestructuraIndex.destroyUsoInfraestructura({{$usoinfraestructura->id}})">
                                                                <i class="material-icons right">
                                                                    delete_sweep
                                                                </i>
                                                                Eliminar
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
