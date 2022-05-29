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
                                        <form method="POST" id="interlocutor-form" action="{{route('accompaniments.updateinterlocutor', $accompaniment)}}"  accept-charset="UTF-8" enctype="multipart/form-data">
                                            @csrf
                                            {!! method_field('PUT')!!}
                                            <div class="wizard clearfix">
                                                @include('articulation.shared.interlocutor-talent-form')
                                                <div class="actions clearfix right-align">
                                                    <ul role="menu" aria-label="Paginación">
                                                        <li aria-hidden="false" aria-disabled="false">
                                                            <a href="{{route('accompaniments.show', $accompaniment)}}" role="menuitem" class="waves-effect waves-blue btn-flat orange-text">Volver atrás</a>
                                                        </li>
                                                        <li class="disabled" aria-disabled="true">
                                                            <button type="submit" role="menuitem" class="btn waves-effect waves-blue btn-flat orange-text">Guardar</button>
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

