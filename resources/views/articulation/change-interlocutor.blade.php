@extends('layouts.app')
@section('meta-title', __('articulation-stage'))
@section('content')
<main class="mn-inner">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <i class="material-icons left">autorenew</i>{{__('articulation-stage')}}
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">{{ __('Home') }}</a></li>
                    <li ><a href="{{route('articulation-stage')}}">{{__('articulation-stage')}}</a></li>
                    <li ><a href="{{route('articulation-stage.show',  $articulationStage)}}">{{ $articulationStage->present()->articulationStageCode() }}</a></li>
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
                                        <li class="text-mailbox ">La {{__('articulation-stage')}}  se encuentra actualmente {{$articulationStage->present()->articulationStageStatus()}}</li>
                                        <div class="right">
                                            <li class="text-mailbox">Fecha registro: {{$articulationStage->present()->articulationStageCreatedDate()}}</li>
                                        </div>
                                    </ul>
                                </div>
                                <div class="mailbox-view no-s">
                                    <div class="mailbox-view-header">
                                        <form method="POST" id="interlocutor-form" action="{{route('articulation-stage.updateinterlocutor', $articulationStage)}}"  accept-charset="UTF-8" enctype="multipart/form-data">
                                            @csrf
                                            {!! method_field('PUT')!!}
                                            <div class="wizard clearfix">
                                                @include('articulation.shared.interlocutor-talent-form')
                                                <div class="actions clearfix right-align">
                                                    <ul role="menu" aria-label="Paginación">
                                                        <li aria-hidden="false" aria-disabled="false">
                                                            <a href="{{route('articulation-stage.show', $articulationStage)}}" role="menuitem" class="waves-effect waves-blue btn-flat primary-text">Volver atrás</a>
                                                        </li>
                                                        <li class="disabled" aria-disabled="true">
                                                            <button type="submit" role="menuitem" class="btn waves-effect waves-blue btn-flat primary-text">Guardar</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('articulation.shared.interlocutor-talents-modal')
</main>
@endsection

