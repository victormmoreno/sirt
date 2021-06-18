@extends('layouts.app')
@section('meta-title', 'Articulaciones PBT')
@section('content')
@php
  $year = Carbon\Carbon::now()->year;
@endphp
<main class="mn-inner">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s8 m8 l5">
                <h5 class="left-align orange-text text-darken-3">
                    <i class="material-icons left">
                      autorenew
                    </i>
                    Articulaciones PBT
                </h5>
            </div>
            <div class="col s4 m4 l5 offset-l2  rigth-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li ><a href="{{route('articulaciones.index')}}">Articulaciones PBT</a></li>
                    <li ><a href="{{route('articulaciones.show', $actividad->articulacionpbt->id)}}">detalle</a></li>
                    <li class="active">Inicio</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12 no-p-h">
                <div class="card mailbox-content">
                    <div class="card-content">
                        <div class="row no-m-t no-m-b">
                            <div class="col s12 m12 l12">
                                <div class="mailbox-options">
                                    <ul>
                                        <li class="text-mailbox active">Inicio</li>
                                        <li class="text-mailbox">Ejecución</li>
                                        <li class="text-mailbox">Cierre</li>
                                        <div class="right">
                                            <li class="text-mailbox "> Fase actual: {{$actividad->articulacionpbt->present()->articulacionPbtNameFase()}}</li>
                                            <li class="text-mailbox">Fecha Inicio: {{$actividad->present()->startDate()}}</li>   
                                        </div>
                                    </ul>
                                </div>
                                <div class="mailbox-view no-s">
                                    <div class="mailbox-view-header no-m-b no-m-t">
                                        <div class="right mailbox-buttons no-s">
                                            @if (!$actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsSuspendido()))
                                                @if ($actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio()))
                                                    @if ($ultimo_movimiento == null || $ultimo_movimiento->movimiento->movimiento == App\Models\Movimiento::IsCambiar() || $ultimo_movimiento->movimiento->movimiento  == App\Models\Movimiento::IsNoAprobar() || $ultimo_movimiento->movimiento->movimiento == App\Models\Movimiento::IsReversar())
                                                        <a href="{{route('articulacion.solicitar.aprobacion', [$actividad->articulacionpbt->id, 'Inicio'])}}" class="waves-effect waves-light btn orange m-t-xs">Solicitar aprobación al talento interlocutor</a>
                                                    @else
                                                        @if ($ultimo_movimiento->movimiento->movimiento == App\Models\Movimiento::IsSolicitarTalento())
                                                        <a disabled class="waves-effect waves-orange btn disabled m-t-xs">
                                                            Solicitud enviada al talento interlocutor
                                                        </a>
                                                        @endif
                                                        @if($ultimo_movimiento->movimiento->movimiento == App\Models\Movimiento::IsAprobar() && $ultimo_movimiento->role->name == App\User::IsTalento())
                                                        <a disabled class="waves-effect waves-orange btn disabled m-t-xs">
                                                            El talento interlocutor aprobó la fase de Inicio, aún falta la aprobación del dinamizador
                                                        </a>
                                                        @endif
                                                    @endif
                                                @else
                                                    <a disabled class="waves-effect waves-orange btn disabled orange m-t-xs">
                                                        La articulación no se encuentra en esta fase
                                                    </a>
                                                @endif
                                                @if ($actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio()))
                                                    <a target="_blank" href="{{route('pdf.articulacion.inicio', $actividad->articulacionpbt->id)}}" class="waves-effect waves-grey btn-flat m-t-xs">Descargar Formulario</a>
                                                    <a href="{{route('articulacion.entregables.inicio', $actividad->articulacionpbt->id)}}" class="waves-effect waves-grey btn-flat m-t-xs">Entregables</a>
                                                @endif
                                            @endif
                                                                          
                                        </div>
                                    </div>
                                    <div class="mailbox-view-header">
                                        <div class="left">
                                            <span class="mailbox-title p-v-lg">{{$actividad->present()->actividadCode()}} - {{$actividad->present()->actividadName()}}</span>
                                            <div class="left">
                                                <span class="mailbox-title">{{$actividad->present()->actividadUserAsesor()}}</span>
                                                <span class="mailbox-author">{{$actividad->present()->actividadUserRolesAsesor()}} </span>
                                            </div>
                                        </div>
                                        <div class="right mailbox-buttons p-v-lg">
                                            <div class="right">
                                                <span class="mailbox-title">{{$actividad->present()->actividadNode()}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider mailbox-divider"></div>
                                    <div class="mailbox-text">
                                        <div class="row">
                                            <div class="col s12 m12 l9">
                                                <form id="frmUpdateArticulacion_FaseInicio" action="{{route('articulaciones.update', $actividad->articulacionpbt->id)}}" method="POST" onsubmit="return checkSubmit()">
                                                    {!! method_field('PUT')!!}
                                                    {!! csrf_field() !!}
                                                    @include('articulacionespbt.form.form_inicio', ['btnText' => 'Modificar'])
                                                </form>
                                            </div>
                                            <div class="col s12 m12 l3 hide-on-med-and-down">
                                                <ul class="collection collection-response">
                                                    @if(isset($actividad))
                                                        <li class="collection-item dismissable">
                                                            <a target="_blank" href="{{route('proyecto.detalle', $actividad->articulacionpbt->present()->articulacionPbtIdProyecto())}}" class="secondary-content orange-text"><i class="material-icons">link</i></a>
                                                            <span class="title">PBT</span>
                                                            <p>{{$actividad->articulacionpbt->present()->articulacionPbtCodeProyecto()}}<br>
                                                                {{$actividad->articulacionpbt->present()->articulacionPbtNameProyecto()}}
                                                            </p>
                                                        </li>
                                                        <li class="collection-item dismissable">
                                                            <a  onclick="detallesIdeaPorId({{$actividad->articulacionpbt->present()->articulacionPbtIdIdeaProyecto()}})" class="secondary-content orange-text">
                                                                <i class="material-icons">link</i>
                                                            </a>
                                                            <span class="title">Idea:</span>
                                                            <p>{{$actividad->articulacionpbt->present()->articulacionPbtCodeIdeaProyecto()}}<br>
                                                                {{$actividad->articulacionpbt->present()->articulacionPbtNameIdeaProyecto()}}
                                                            </p>
                                                        </li>
                                                    @else
                                                        <li class="collection-item dismissable">
                                                            <span class="title">Sin resultados</span>                          
                                                        </li>
                                                    @endif
                                                </ul>
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
    @include('articulacionespbt.modal.project-modal')
    @include('articulacionespbt.modal.talent-modal')
    @include('ideas.modals')
</main>
@endsection
@push('script')
    <script>
        checkTipoVinculacion({{$actividad->articulacionpbt->tipo_vinculacion}});
    </script>
@endpush