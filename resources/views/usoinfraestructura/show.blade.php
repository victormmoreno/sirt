@extends('layouts.app')
@section('meta-title', 'Asesoría y Uso')
@section('content')
	<main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b m-r-lg m-l-lg">
                <div class="left left-align">
                    <h5 class="left-align primary-text">
                        <i class="material-icons left">domain</i> Asesorías y usos
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{route('home')}}">{{ __('Home') }}</a></li>
                        <li><a href="{{route('usoinfraestructura.index')}}">Asesoría y uso</a></li>
                    <li class="active">Detalle</li>
                    </ol>
                </div>
            </div>
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="card mailbox-content">
                        <div class="card-content">
                            <div class="bg-primary">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col s12 m12 l12">
                                            <div class="card card-transparent no-m">
                                                <div class="card-content  white-text">
                                                    <div class="row">
                                                        <div class="col s12 m6 l9">
                                                            <h4>{{$usoinfraestructura->present()->actividadUsoInfraestructura()}}</h4>
                                                                <p>Tecnoparque {{$usoinfraestructura->present()->nodoUso()}}</p>
                                                        </div>
                                                        <div class="col s12 m6 l3 right-align">
                                                            <h4>${{number_format($totalCostos,0)}}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <div class="card card-transparent no-m">
                                            <div class="card-content invoice-relative-content">
                                                <div class="row">
                                                    <div class="left col s12 m6 l9">
                                                        <span class="mailbox-title primary-text">Información de {{$usoinfraestructura->present()->tipoUsoInfraestructura()}}</span>
                                                        <div class="divider"></div>
                                                    </div>
                                                    <div class="col s12 m6 l3 right-align">
                                                        @can('update', $usoinfraestructura)
                                                        <a href="{{route('usoinfraestructura.edit',$usoinfraestructura->id)}}" class="btn-floating btn-large waves-effect waves-grey bg-secondary white-text "><i class="material-icons">edit</i></a>
                                                        @endcan
                                                        @can('destroy', $usoinfraestructura)
                                                            <a href="javascript:void(0)" onclick="usoinfraestructuraIndex.destroyUsoInfraestructura({{$usoinfraestructura->id}})" class="btn-floating btn-large waves-effect waves-grey bg-danger white-text mt-2"><i class="material-icons">delete</i></a>
                                                        @endcan
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col s12 m6 l3">
                                                        <p>
                                                            <span class="primary-text">Fecha de Inicio</span><br>
                                                            <b>{{$usoinfraestructura->present()->asesorableStartDate()}}</b>
                                                        </p>
                                                    </div>
                                                    <div class="col s12 m6 l3">
                                                        <p>
                                                            <span class="primary-text">Fase de {{$usoinfraestructura->present()->tipoUsoInfraestructura()}}</span><br>
                                                            <b>{{$usoinfraestructura->present()->asesorablePhase()}}</b>
                                                        </p>
                                                    </div>
                                                    @if(isset($usoinfraestructura->asesorable->codigo_proyecto) && $usoinfraestructura->asesorable->codigo_proyecto != null)
                                                    <div class="col s12 m6 l3">
                                                        <p>
                                                            <span class="primary-text">Sublinea:</span><br>
                                                            <b>{{$usoinfraestructura->asesorable->sublinea->nombre}}</b>
                                                        </p>
                                                    </div>
                                                    <div class="col s12 m6 l3">
                                                        <p>
                                                            <span class="primary-text">Área de Conocimiento:</span><br>
                                                            <b> {{$usoinfraestructura->asesorable->areaconocimiento->nombre}}</b>
                                                        </p>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <div class="left col s12 m12 l12">
                                                        <span class="mailbox-title primary-text">Información Asesoría y uso</span>
                                                        <div class="divider"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col s12 m6 l3">
                                                        <p>
                                                            <span class="primary-text">Fecha</span><br>
                                                            <b>{{$usoinfraestructura->fecha->isoformat('LL')}}</b>
                                                        </p>
                                                    </div>
                                                    <div class="col s12 m6 l3">
                                                        <p>
                                                            <span class="primary-text">Asesoria Directa</span><br>
                                                            <b>{{$usoinfraestructura->usogestores->sum('pivot.asesoria_directa')}}</b>
                                                        </p>
                                                    </div>
                                                    <div class="col s12 m6 l3">
                                                        <p>
                                                            <span class="primary-text">Asesoria Indirecta</span><br>
                                                            <b>{{$usoinfraestructura->usogestores->sum('pivot.asesoria_indirecta')}}</b>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col s12 m12 l6">
                                                        <p>
                                                            <span class="primary-text">Descripción</span><br>
                                                            <b>{{isset($usoinfraestructura->descripcion) && $usoinfraestructura->descripcion != '' ? $usoinfraestructura->descripcion : 'No registra'}}</b>
                                                        </p>
                                                    </div>
                                                    <div class="col s12 m12 l6">
                                                        <p>
                                                            <span class="primary-text">Próximos compromisos</span><br>
                                                            <b>{{ isset($usoinfraestructura->compromisos) ? $usoinfraestructura->compromisos : 'No Registra'}}</b>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col s12 m6 l4 right right-align">
                                                        <span class="mailbox-title primary-text">Costos</span>
                                                        <div class="divider"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col s12 m12 l8">
                                                        <div class="row">
                                                            <div class="col s12 m12 l8">
                                                                <table class="table responsive-table highlight centered bordered">
                                                                    <thead class="bg-primary white-text">
                                                                        <tr>
                                                                            <th class="center-align">Asesor</th>
                                                                            <th class="center-align">Horas Asesoria Directa</th>
                                                                            <th class="center-align">Horas Asesoria Indirecta</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse($usoinfraestructura->usogestores as $usogestor)
                                                                            <tr>
                                                                                @if(isset( $usogestor))
                                                                                    <td class="center-align">
                                                                                        {{$usogestor->present()->userDocumento()}} - {{$usogestor->present()->userFullName()}}
                                                                                    </td>
                                                                                @endif
                                                                                @if ($usogestor->pivot->asesoria_directa == 1)
                                                                                    <td class="center-align">
                                                                                        {{$usogestor->pivot->asesoria_directa}}  hora
                                                                                    </td>
                                                                                @elseif($usogestor->pivot->asesoria_directa == 0)
                                                                                    <td class="center-align">
                                                                                        No registra
                                                                                    </td>
                                                                                @else
                                                                                    <td class="center-align">
                                                                                        {{$usogestor->pivot->asesoria_directa}}  horas
                                                                                    </td>
                                                                                @endif
                                                                                @if ($usogestor->pivot->asesoria_indirecta == 1)
                                                                                    <td class="center-align">
                                                                                        {{$usogestor->pivot->asesoria_indirecta}}  hora
                                                                                    </td>
                                                                                @elseif($usogestor->pivot->asesoria_indirecta == 0)
                                                                                    <td class="center-align">0</td>
                                                                                @else
                                                                                    <td class="center-align">
                                                                                        {{$usogestor->pivot->asesoria_indirecta}}  horas
                                                                                    </td>
                                                                                @endif
                                                                            </tr>
                                                                        @empty
                                                                        <tr>
                                                                            <td colspan="3">
                                                                                <i class="large material-icons center">block</i>
                                                                                <p class="center-align">No se encontraron resultados</p>
                                                                            <td>
                                                                        </tr>
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="col s12 m12 l4">
                                                                <table class="table responsive-table highlight centered bordered">
                                                                    <thead class="bg-primary white-text">
                                                                        <tr>
                                                                            <th>Talentos({{$usoinfraestructura->usotalentos->count()}})</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse($usoinfraestructura->usotalentos as $usotal)
                                                                        <tr>
                                                                            <td>{{$usotal->user()->withTrashed()->first()->documento}} - {{$usotal->user()->withTrashed()->first()->nombres}} {{$usotal->user()->withTrashed()->first()->apellidos}}</td>
                                                                        </tr>
                                                                        @empty
                                                                        <tr>
                                                                            <td class="center-align">
                                                                                <i class="large material-icons center">
                                                                                    block
                                                                                </i>
                                                                                <p class="center-align">No se encontraron resultados</p>
                                                                            </td>
                                                                        </tr>
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col s12 m12 l6">
                                                                <table class="table responsive-table highlight centered bordered">
                                                                    <thead class="bg-primary white-text">
                                                                        <tr>
                                                                            <th>Equipo ({{$equipos->count()}})</th>
                                                                            <th>Referencia</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse($equipos as $equipo)
                                                                            <tr>
                                                                                <td>{{$equipo->nombre}}</td>
                                                                                <td>{{$equipo->referencia}}</td>
                                                                            </tr>
                                                                        @empty
                                                                            <tr>
                                                                                <td>
                                                                                    <i class="large material-icons center">
                                                                                        block
                                                                                    </i>
                                                                                    <p class="center-align">No se encontraron resultados</p>
                                                                                </td>
                                                                            </tr>
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="col s12 m12 l6">
                                                                <table class="table responsive-table highlight centered bordered">
                                                                    <thead class="bg-primary white-text">
                                                                        <tr>
                                                                            <th>Materiales de Formación ({{$usoinfraestructura->usomateriales->count()}})</th>
                                                                            <th>Unidades</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse($usoinfraestructura->usomateriales as $usomaterial)
                                                                            <tr>
                                                                                <td>{{$usomaterial->codigo_material}} {{$usomaterial->nombre}}</td>
                                                                                <td>{{$usomaterial->pivot->unidad}}</td>
                                                                            </tr>
                                                                        @empty
                                                                        <tr >
                                                                            <td colspan="2">
                                                                                <i class="large material-icons center">
                                                                                    block
                                                                                </i>
                                                                                <p>No se encontraron resultados</p>
                                                                            </td>
                                                                        </tr>
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m12 l4 right-align">
                                                        <table class="table responsive-table striped">
                                                            <thead class="bg-primary white-text">
                                                                <tr>
                                                                    <th>Item</th>
                                                                    <th class="right-align">Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Costos de Asesoria</td>
                                                                    <td class="right-align">$ {{number_format($usoinfraestructura->usogestores->sum('pivot.costo_asesoria'),0)}}</td>
                                                                </tr>
                                                                @if(isset($usoinfraestructura->usoequipos))
                                                                    <tr>
                                                                        <td>Costos de equipos</td>
                                                                        <td class="right-align">$ {{number_format($usoinfraestructura->usoequipos->sum('pivot.costo_equipo'),0)}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Costos Administrativos</td>
                                                                        <td class="right-align">$ {{number_format($usoinfraestructura->usoequipos->sum('pivot.costo_administrativo'),0)}}</td>
                                                                    </tr>
                                                                @endif
                                                                @if(isset($usoinfraestructura->usomateriales))
                                                                    <tr>
                                                                        <td>Costos de Materiales de formación</td>
                                                                        <td class="right-align">$ {{number_format($usoinfraestructura->usomateriales->sum('pivot.costo_material'),0)}}</td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                        <div class="col s12 m12 l8 right right-align">
                                                            <div class="text-right">
                                                                <h6 class="m-t-md secondary-text"><b>Total</b></h6>
                                                                <h4 class="text-success">$ {{number_format($totalCostos,0)}}</h4>
                                                                <div class="divider"></div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col s12 right-align m-t-sm">
                                                                @can('update', $usoinfraestructura)
                                                                    <a href="{{route('usoinfraestructura.edit',$usoinfraestructura->id)}}" class="waves-effect waves-grey btn bg-secondary center-align" ><i class="material-icons right">edit</i>Cambiar Información</a>
                                                                @endcan
                                                                @can('destroy', $usoinfraestructura)
                                                                    <a href="javascript:void(0)" class="waves-grey bg-danger btn center-align" onclick="usoinfraestructuraIndex.destroyUsoInfraestructura({{$usoinfraestructura->id}})">
                                                                        <i class="material-icons right">
                                                                            delete_sweep
                                                                        </i>
                                                                        Eliminar
                                                                    </a>
                                                                @endcan
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
        </div>
	</main>
@endsection
