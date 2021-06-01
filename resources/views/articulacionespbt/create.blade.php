@extends('layouts.app')
@section('meta-title', 'Articulaciones PBT')
@section('content')
@php
  $year = Carbon\Carbon::now()->year;
@endphp
<main class="mn-inner">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l6">
                <h5 class="left-align orange-text text-darken-3">
                    <i class="material-icons left">
                        autorenew
                    </i>
                    Articulaciones PBT
                </h5>
            </div>
            <div class="col s12 m12 l5 offset-l1 rigth-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li class="active"><a href="{{route('articulaciones.index')}}">Articulaciones PBT</a></li>
                    <li class="active">NuevaArticulación</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12 no-p-h">
                <div class="card mailbox-content">
                    <div class="card-content">
                        <div class="row no-m-t no-m-b">
                            <div class="col s12 m12 l9">
                                <div class="mailbox-options">
                                    <ul>
                                        <li class="text-mailbox active">Inicio</li>
                                        <li class="text-mailbox">Ejecución</li>
                                        <li class="text-mailbox">Cierre</li>
                                    </ul>
                                </div>
                                <div class="mailbox-view">
                                    <div class="mailbox-view-header">
                                        <div class="left">
                                            <div class="left">
                                                <span class="mailbox-title">{{ auth()->user()->present()->userFullName() }}</span>
                                                <span class="mailbox-author hide-on-med-and-down">{{ auth()->user()->present()->userRolesNames() }}</span>
                                            </div>
                                        </div>
                                        <div class="right mailbox-buttons hide-on-med-and-down">
                                        <span class="mailbox-title">Tecnoparque Nodo {{ \NodoHelper::returnNameNodoUsuario() }}</span>
                                        </div>
                                    </div>
                                    <div class="divider mailbox-divider"></div>
                                    <div class="mailbox-text">
                                        <form id="frmArticulacionpbt_FaseInicio" action="{{route('articulaciones.store')}}" method="POST" onsubmit="return checkSubmit()">
                                            {!! csrf_field() !!}
                                            @include('articulacionespbt.form.form_inicio', ['btnText' => 'Guardar'])
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 m12 l3 hide-on-med-and-down">
                                <div class="mailbox-options">
                                    <ul>
                                        <div class="right">
                                            <li class="text-mailbox">Información Articulación</li>
                                        </div>
                                    </ul>
                                </div>
                                <ul class="collection collection-response">
                                    <li class="collection-item dismissable">
                                        <span class="title">Sin resultados</span>                          
                                    </li>
                                </ul>
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
