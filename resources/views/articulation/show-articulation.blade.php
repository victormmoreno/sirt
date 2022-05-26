@extends('layouts.app')
@section('meta-title', __('Accompaniments'))
@section('content')
<main class="mn-inner">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s8 m8 l5">
                <h5 class="left-align orange-text text-darken-3">
                    <i class="material-icons left">
                        autorenew
                    </i>
                    Articulaciones
                </h5>
            </div>
            <div class="col s4 m4 l5 offset-l2  rigth-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    {{-- <li ><a href="{{route('articulaciones.index')}}">Articulaciones</a></li> --}}
                    <li class="active">detalle</li>
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
                                        <li class="text-mailbox ">La articulación se encuentra actualmente en la fase de inicio</li>
                                        <div class="right">
                                            <li class="text-mailbox">Fecha Inicio: {{$articulation->start_date}}</li>
                                        </div>
                                    </ul>
                                </div>
                                <div class="mailbox-view no-s">


                                    {{-- <div class="mailbox-view-header">
                                        <div class="left">
                                            <span class="mailbox-title p-v-lg">{{$articulacion->present()->articulacionPbtCode()}} - {{$articulacion->present()->articulacionPbtName()}}</span>

                                            <div class="left">
                                                <span class="mailbox-title">{{$articulacion->present()->articulacionPbtUserAsesor()}}</span>
                                                <span class="mailbox-author">{{$articulacion->present()->articulacionPbtUserRolesAsesor()}} </span>
                                            </div>
                                        </div>
                                        <div class="right mailbox-buttons p-v-lg">
                                            <div class="right">
                                                <span class="mailbox-title">{{$articulacion->present()->articulacionPbtNodo()}}</span>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="divider mailbox-divider"></div>
                                    <div class="mailbox-text">
                                        <div class="row">
                                            <div class="col s12">
                                                {{-- @include('articulacionespbt.history-change') --}}
                                            </div>
                                            <div class="col s12">
                                                <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                                                    <li class="tab col s3"><a href="#faseinicio" class="active">Inicio</a></li>
                                                    <li class="tab col s3"><a class="" href="#faseejecucion">Ejecución</a></li>
                                                    <li class="tab col s3"><a href="#fasecierre" class="">Cierre</a></li>
                                                </ul>
                                            </div>
                                            {{-- <div id="faseinicio" class="col s12" style="display: block;">
                                                @include('articulacionespbt.detail.detail-fase-inicio')
                                            </div>
                                            <div id="faseejecucion" class="col s12" style="display: none;">
                                                @include('articulacionespbt.detail.detail-fase-ejecucion')
                                            </div>
                                            <div id="fasecierre" class="col s12" style="display: none;">
                                                @include('articulacionespbt.detail.detail-fase-cierre')
                                            </div> --}}
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

