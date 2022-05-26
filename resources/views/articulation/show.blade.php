@extends('layouts.app')
@section('meta-title', __('Accompaniments'))
@section('content')
<main class="mn-inner">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="left left-align">
                <h5 class="left-align orange-text text-darken-3">
                    <i class="material-icons left">autorenew</i>{{__('Accompaniments')}}
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">{{ __('Home') }}</a></li>
                    <li ><a href="{{route('accompaniments')}}">{{__('Accompaniments')}}</a></li>
                    <li class="active">{{ __('Details') }}</li>
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
                                        <li class="text-mailbox ">La {{__('Accompaniments')}}  se encuentra actualmente {{$accompaniment->present()->accompanimentStatus()}}</li>
                                        <div class="right">
                                            <li class="text-mailbox">Fecha registro: {{$accompaniment->present()->accompanimentCreatedDate()}}</li>
                                        </div>
                                    </ul>
                                </div>
                                <div class="mailbox-view no-s">
                                    <div class="mailbox-view-header">
                                        <div class="left">
                                            <div class="left">
                                                <span class="mailbox-title">{{$accompaniment->code}} - {{$accompaniment->name}}
                                                <a href="" class="orange-text text-darken-2 pointer tooltipped" data-position="right" data-tooltip="editar {{__('Accompaniments')}}"><i class="tiny material-icons">edit</i></a></span>
                                                <span class="mailbox-title">{{__('Node')}} {{$accompaniment->present()->accompanimentNode()}}</span>
                                                <span class="mailbox-author">{{$accompaniment->present()->accompanimentInterlocutorTalent()}} ({{__('Interlocutory talent')}}) <a href="" class="orange-text text-darken-2 pointer tooltipped" data-position="right" data-tooltip="cambiar {{__('Interlocutory talent')}}"><i class="tiny material-icons">edit</i></a></span>
                                            </div>
                                        </div>
                                        <div class="right mailbox-buttons">
                                            <a href="{{route('articulations.create', $accompaniment->id )}}" class="waves-effect waves-orange btn orange m-t-xs">{{__('New Articulation')}}</a>
                                            @if((session()->has('login_role') && session()->get('login_role') === App\User::IsDinamizador()) && !$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsSuspendido()))
                                                <a href="" class="waves-effect waves-grey btn-flat m-t-xs">Cambiar articulador</a>
                                            @endif
                                            @if((session()->has('login_role') && session()->get('login_role') === App\User::IsArticulador()))
                                                <a href="" class="waves-effect waves-grey btn-flat m-t-xs">Descargar</a>
                                                <a href="" class="waves-effect waves-orange btn-flat m-t-xs">Cerrar</a>
                                            @endif
                                            <a class="waves-effect waves-red btn-flat m-t-xs">Eliminar</a>
                                        </div>
                                    </div>
                                    <div class="divider mailbox-divider"></div>
                                    <div class="mailbox-text">
                                        <div class="col s12 m12 l12">
                                            <div class="card card-panel card-transparent server-card">
                                                <div class="card-content">
                                                    <div class="card-options">
                                                        <ul>
                                                            <li class="red-text"><span class="badge blue-grey lighten-3">{{$accompaniment->present()->accompanimentStatus()}}</span></li>
                                                        </ul>
                                                    </div>
                                                    <span class="card-title">{{$accompaniment->present()->accompanimentCode()}} - {{$accompaniment->present()->accompanimentName()}}</span>
                                                    <div class="stats-info">
                                                        <ul>
                                                            <li>Código<div class="percent-info black-text"> {{$accompaniment->present()->accompanimentCode()}}</div></li>
                                                            <li>Nombre<div class="percent-info black-text right">{{$accompaniment->present()->accompanimentName()}}</div></li>
                                                            <li>Descripción<div class="percent-info black-text right">{{$accompaniment->present()->accompanimentDescription()}}</div></li>
                                                            <li>Fecha inicio<div class="percent-info black-text right">{{$accompaniment->present()->accompanimentStartDate()}}</div></li>
                                                            <li>Fecha fin<div class="percent-info black-text right">{{$accompaniment->present()->accompanimentEndDate()}}</div></li>
                                                            <li>Formato de confidencialidad<div class="percent-info black-text right">{{$accompaniment->present()->accompanimentConfidentialityFormat()}}</div></li>
                                                            <li>terminos y condiciones<div class="percent-info black-text right">{{$accompaniment->present()->accompanimentTermsVerifiedAt()}}</div></li>
                                                            <li>Talento Interlocutor<div class="percent-info black-text right">{{$accompaniment->present()->accompanimentInterlocutorTalent()}}</div></li>
                                                            <li>Creado por<div class="percent-info black-text right">{{$accompaniment->present()->accompanimentBy()}}</div></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="flow-text orange-text">Articulaciones  {{ 'con '.$accompaniment->present()->accompanimentables()}}</span>
                                            <div class="row">

                                                @forelse($articulations as $articulation)

                                                    <div class="col s12 m12 l4">
                                                        <div class="card card-panel server-card">

                                                            <div class="card-content">
                                                                <div class="card-options">
                                                                    <ul>
                                                                        <li><a class="dropdown-button "  href='#' data-activates="dropdown{{$articulation->id}}"><i class="material-icons">more_vert</i></a></li>
                                                                    </ul>
                                                                </div>
                                                                <ul id="dropdown{{$articulation->id}}" class="dropdown-content">
                                                                    <li><a href="{{route('articulations.show', $articulation->id)}}">Editar</a></li>
                                                                    <li><a href="#!" class="red-text">Elimnar</a></li>
                                                                </ul>
                                                                <span class="card-title">{{$articulation->present()->articulationCode()}} - {{$articulation->present()->articulationName()}}</span>
                                                                <div class="server-load row">
                                                                    <div class="server-stat col s4">
                                                                        <p class="">{{$articulation->users_count}}</p>
                                                                        <span>Talentos participantes</span>
                                                                    </div>
                                                                    <div class="server-stat col s4">
                                                                        <p>{{$articulation->present()->articulationPhase()}}</p>
                                                                        <span>{{__('Phase')}}</span>
                                                                    </div>
                                                                    <div class="server-stat col s4">
                                                                        <p>{{$articulation->progress}}%</p>
                                                                        <span>{{__('Progress')}}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="stats-info">
                                                                    <ul>
                                                                        <li>{{__('Description')}}<div class="percent-info black-text right">{{Str::limit($articulation->present()->articulationDescription(),60)}} </div></li>
                                                                        <li>{{__('Start Date')}}<div class="percent-info black-text right">{{$articulation->present()->articulationStartDate()}}</div></li>
                                                                        <li>{{__('End Date')}}<div class="percent-info black-text right">{{$articulation->present()->articulationEndDate()}}</div></li>
                                                                        <li>{{__('End Date')}}<div class="percent-info black-text right">{{$articulation->present()->articulationExpectedEndDate()}}</div></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="progress stats-card-progress ">
                                                                <div class="determinate {{$articulation->progress >= 0 && $articulation->progress <=25 ? 'red' : ($articulation->progress > 25 && $articulation->progress <= 50 ? 'yellow' : ($articulation->progress > 50 && $articulation->progress <= 75 ? 'orange' : 'green' ))}}" style="width: {{$articulation->progress}}%"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                <div class="center-align">
                                                    <p><i class=" large material-icons orange-text text-darken-2">portable_wifi_off</i></p>
                                                    <p><span class=" flow-text">Aún no registras {{ __('Articulations') }}</span></p>
                                                    <p><a href="{{route('articulations.create', $accompaniment->id )}}" class="waves-effect waves-orange btn orange m-t-xs">{{ __('New Articulation') }}</a></p>
                                                </div>
                                                @endforelse
                                            </div>
                                            <div class="center-align">
                                                {!! $articulations->render() !!}
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

