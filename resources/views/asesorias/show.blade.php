@extends('layouts.app')
@section('meta-title', "Asesoría y Uso  - $asesorie->codigo")
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
                        <li><a href="{{route('asesorias.index')}}">Asesoría y uso</a></li>
                    <li class="active">{{ $asesorie->codigo }}</li>
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
                                                            <h4>{{$asesorie->present()->asesorable()}}</h4>
                                                            <p>Tecnoparque {{$asesorie->present()->asesorieNode()}}</p>
                                                        </div>
                                                        <div class="col s12 m6 l3 right-align">
                                                            <h4>${{number_format($totalCosts,0)}}</h4>
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
                                                        <span class="mailbox-title primary-text">Información de {{$asesorie->present()->asesorableType()}}</span>
                                                        <div class="divider"></div>
                                                    </div>
                                                    <div class="col s12 m6 l3 right-align">
                                                        <a target="_blank"  href="{!!$asesorie->present()->asesorableRoute()!!}" class="btn-floating btn-large waves-effect waves-grey bg-info white-text "><i class="material-icons">remove_red_eye</i></a>
                                                        @can('update', $asesorie)
                                                        <a href="{{route('asesorias.edit',$asesorie->codigo)}}" class="btn-floating btn-large waves-effect waves-grey bg-warning white-text"><i class="material-icons">edit</i></a>
                                                        @endcan
                                                        @can('destroy', $asesorie)
                                                            <a href="javascript:void(0)" onclick="asesorieIndex.destroyAsesorie({{$asesorie->id}})" class="btn-floating btn-large waves-effect waves-grey bg-danger white-text mt-2"><i class="material-icons">delete</i></a>
                                                        @endcan
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col s12 m6 l3">
                                                        <p>
                                                            <span class="primary-text">Fecha de Inicio</span><br>
                                                            <b>{{$asesorie->present()->asesorieStartDate()}}</b>
                                                        </p>
                                                    </div>
                                                    <div class="col s12 m6 l3">
                                                        <p>
                                                            <span class="primary-text">Fase de {{$asesorie->present()->asesorableType()}}</span><br>
                                                            <b>{{$asesorie->present()->asesorablePhase()}}</b>
                                                        </p>
                                                    </div>
                                                    @if(isset($asesorie->asesorable) && class_basename($asesorie->asesorable) == 'Proyecto')
                                                        <div class="col s12 m6 l3">
                                                            <p>
                                                                <span class="primary-text">Sublinea:</span><br>
                                                                <b>{{$asesorie->asesorable->sublinea->nombre}}</b>
                                                            </p>
                                                        </div>
                                                        <div class="col s12 m6 l3">
                                                            <p>
                                                                <span class="primary-text">Área de Conocimiento:</span><br>
                                                                <b> {{$asesorie->asesorable->areaconocimiento->nombre}}</b>
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
                                                            <span class="primary-text">Código</span><br>
                                                            <b>{{$asesorie->codigo}}</b>
                                                        </p>
                                                    </div>
                                                    <div class="col s12 m6 l3">
                                                        <p>
                                                            <span class="primary-text">Fecha</span><br>
                                                            <b>{{$asesorie->fecha->isoformat('LL')}}</b>
                                                        </p>
                                                    </div>
                                                    <div class="col s12 m6 l3">
                                                        <p>
                                                            <span class="primary-text">Asesoria Directa</span><br>
                                                            <b>{{$asesorie->asesores->sum('pivot.asesoria_directa')}}</b>
                                                        </p>
                                                    </div>
                                                    <div class="col s12 m6 l3">
                                                        <p>
                                                            <span class="primary-text">Asesoria Indirecta</span><br>
                                                            <b>{{$asesorie->asesores->sum('pivot.asesoria_indirecta')}}</b>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col s12 m12 l6">
                                                        <p>
                                                            <span class="primary-text">Descripción</span><br>
                                                            <b>{{isset($asesorie->descripcion) && $asesorie->descripcion != '' ? $asesorie->descripcion : 'No registra'}}</b>
                                                        </p>
                                                    </div>
                                                    <div class="col s12 m12 l6">
                                                        <p>
                                                            <span class="primary-text">Próximos compromisos</span><br>
                                                            <b>{{ isset($asesorie->compromisos) ? $asesorie->compromisos : 'No Registra'}}</b>
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
                                                                        @forelse($asesorie->asesores as $user)
                                                                            <tr>
                                                                                @if(isset($user))
                                                                                    <td class="center-align">
                                                                                        {{$user->present()->userDocumento()}} - {{$user->present()->userFullName()}}
                                                                                    </td>
                                                                                @endif
                                                                                @if ($user->pivot->asesoria_directa == 1)
                                                                                    <td class="center-align">
                                                                                        {{$user->pivot->asesoria_directa}}  hora
                                                                                    </td>
                                                                                @elseif($user->pivot->asesoria_directa == 0)
                                                                                    <td class="center-align">
                                                                                        No registra
                                                                                    </td>
                                                                                @else
                                                                                    <td class="center-align">
                                                                                        {{$user->pivot->asesoria_directa}}  horas
                                                                                    </td>
                                                                                @endif
                                                                                @if ($user->pivot->asesoria_indirecta == 1)
                                                                                    <td class="center-align">
                                                                                        {{$user->pivot->asesoria_indirecta}}  hora
                                                                                    </td>
                                                                                @elseif($user->pivot->asesoria_indirecta == 0)
                                                                                    <td class="center-align">0</td>
                                                                                @else
                                                                                    <td class="center-align">
                                                                                        {{$user->pivot->asesoria_indirecta}}  horas
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
                                                                            <th>Talentos({{$asesorie->participantes->count()}})</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse($asesorie->participantes as $user)
                                                                        <tr>
                                                                            <td>{{$user->documento}} - {{$user->nombres}} {{$user->apellidos}}</td>
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
                                                                            <th>Equipo ({{$devices->count()}})</th>
                                                                            <th>Referencia</th>
                                                                            <th>Tiempo uso (en horas)</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse($asesorie->usoequipos as $device)
                                                                            <tr>
                                                                                <td>{{$device->nombre}}</td>
                                                                                <td>{{$device->referencia}}</td>
                                                                                <td>{{isset($device->pivot->tiempo) ? $device->pivot->tiempo : 0}}</td>
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
                                                                            <th>Materiales de Formación ({{$asesorie->usomateriales->count()}})</th>
                                                                            <th>Unidades</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse($asesorie->usomateriales as $usomaterial)
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
                                                                    <td class="right-align">$ {{number_format($asesorie->asesores->sum('pivot.costo_asesoria'),0)}}</td>
                                                                </tr>
                                                                @if(isset($asesorie->usoequipos))
                                                                    <tr>
                                                                        <td>Costos de equipos</td>
                                                                        <td class="right-align">$ {{number_format($asesorie->usoequipos->sum('pivot.costo_equipo'),0)}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Costos Administrativos</td>
                                                                        <td class="right-align">$ {{number_format($asesorie->usoequipos->sum('pivot.costo_administrativo'),0)}}</td>
                                                                    </tr>
                                                                @endif
                                                                @if(isset($asesorie->usomateriales))
                                                                    <tr>
                                                                        <td>Costos de Materiales de formación</td>
                                                                        <td class="right-align">$ {{number_format($asesorie->usomateriales->sum('pivot.costo_material'),0)}}</td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                        <div class="col s12 m12 l8 right right-align">
                                                            <div class="text-right">
                                                                <h6 class="m-t-md secondary-text"><b>Total</b></h6>
                                                                <h4 class="text-success">$ {{number_format($totalCosts,0)}}</h4>
                                                                <div class="divider"></div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col s12 right-align m-t-sm">
                                                                @can('update', $asesorie)
                                                                    <a href="{{route('asesorias.edit',$asesorie->codigo)}}" class="waves-effect waves-grey btn bg-warning white-text center-align" ><i class="material-icons right">edit</i>Cambiar Información</a>
                                                                @endcan
                                                                @can('destroy', $asesorie)
                                                                    <a href="javascript:void(0)" class="waves-grey bg-danger btn center-align" onclick="asesorieIndex.destroyAsesorie({{$asesorie->id}})">
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
