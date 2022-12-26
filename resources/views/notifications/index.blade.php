@extends('layouts.app')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <i class="material-icons left">notifications_none</i>Notificaciones
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li class="active">Notificaciones</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m6 l6">
                <div class="card card-transparent">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="center-align">
                                    <span class="card-title center-align">
                                        No Leídas
                                    </span>
                                </div>
                                <div class="mailbox-list m-t-lg">
                                    <ul>
                                        @forelse($unreadNotifications as $unreadNotification)
                                        <li>
                                            <a href="{{$unreadNotification->data['link']}}">
                                                <div class="mail-checkbox">
                                                    <i class="material-icons">{{ $unreadNotification->data["icon"] }}</i>
                                                </div>
                                                <h5 class="mail-author">{{ $unreadNotification->data["autor"] }}</h5>
                                                <h4 class="mail-title">{{ $unreadNotification->data["text"] }}</h4>
                                                <p class="hide-on-small-and-down mail-text">{{$unreadNotification->created_at->diffForHumans()}}</p>
                                                <div class="position-top-right p f-12 mail-date"><form method="POST" action="{{route('notifications.read', $unreadNotification->id)}}">
                                                    {{method_field('PATCH')}}
                                                    {{csrf_field()}}
                                                    <div class="mail-checkbox">
                                                        <h5 class="mail-author">
                                                            <button class="position-top-right waves-effect waves-grey btn-flat m-t-xs" >X</button>
                                                        </h5>
                                                    </div>
                                                </form></div>
                                                <div class="position-bottom-right p f-12 mail-date">{{$unreadNotification->created_at->format('h:i A')}}</div>
                                            </a>
                                        </li>
                                        @empty
                                            <li class="notification-drop-title">
                                                <div class="center">
                                                   <i class="large material-icons primary-text center">
                                                        notifications_off
                                                    </i>
                                                    <p class="center-align">No tienes notificationes</p>
                                                </div>
                                              </li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l6">
                <div class="card card-transparent">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="center-align">
                                    <span class="card-title center-align">
                                        Leídas
                                    </span>
                                </div>
                                <div class="mailbox-list m-t-lg">
                                    <ul>
                                        @forelse($readNotifications as $readNotification)

                                        <li>
                                            <a href="{{$readNotification->data['link']}}">
                                                <div class="mail-checkbox">

                                                    <i class="material-icons">{{ $readNotification->data["icon"] }}</i>

                                                </div>
                                                <h5 class="mail-author">{{ $readNotification->data["autor"] }}</h5>
                                                <h4 class="mail-title">{{ $readNotification->data["text"] }}</h4>
                                                <p class="hide-on-small-and-down mail-text">{{$readNotification->created_at->diffForHumans()}}</p>
                                                <div class="position-top-right p f-12 mail-date">
                                                    <form method="POST" action="{{route('notifications.destroy',$readNotification->id)}}">
                                                            {{method_field('DELETE')}}
                                                            {{csrf_field()}}
                                                            <div class="mail-checkbox">
                                                            <h5 class="mail-author"><button class="position-top-right waves-effect waves-grey btn-flat m-t-xs">Borrar</button></h5>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="position-bottom-right p f-12 mail-date">{{$readNotification->created_at->format('h:i A')}}</div>
                                            </a>
                                        </li>
                                        @empty
                                            <li class="notification-drop-title">
                                            <div class="center">
                                               <i class="large material-icons primary-text center">
                                                    notifications_off
                                                </i>
                                                <p class="center-align">No tienes notificationes</p>
                                            </div>
                                          </li>
                                        @endforelse
                                    </ul>
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
