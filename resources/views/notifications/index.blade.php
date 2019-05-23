@extends('layouts.app')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s10 m10 l10">
                        <h5 class="left-align">
                            <i class="material-icons left">
                                notifications_none
                            </i>
                            Notificaciones
                        </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="card ">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <div class="center-align">
                                            <span class="card-title center-align">
                                                No Leídas
                                            </span>
                                        </div>
                                        <div class="mailbox-list">
                                            <ul>
                                                @forelse($unreadNotifications as $unreadNotification)
                                                <li>
                                                    <a href="{{$unreadNotification->data['link']}}">
                                                        
                                                        
                                                        <h5 class="mail-author">{{$unreadNotification->data['text']}}</h5>
                                                        <h4 class="mail-title"></h4>
                                                        <p class="hide-on-small-and-down mail-text"></p>
                                                        
                                                        
                                                    </a>
                                                    <div class="position-top-right p f-12 mail-date">
                                                        <form method="POST" action="{{route('notifications.read',$unreadNotification->id)}}">
                                                            {{method_field('PATCH')}}
                                                            {{csrf_field()}}
                                                            <div class="mail-checkbox">
                                                            <h5 class="mail-author"><button class="position-top-right waves-effect waves-grey btn-flat m-t-xs">Marcar como leída</button></h5>
                                                        </div>
                                                    </form>
                                                    </div>
                                                    
                                                </li>
                                                @empty
                                                    <li>
                                                    <a href="#">
                                                        
                                                        <h5 class="mail-author"></h5>
                                                        <h4 class="mail-title"></h4>
                                                        <p class="hide-on-small-and-down mail-text">No tienes Notificaciones</p>
                                                        <div class="position-top-right p f-12 mail-date"></div>
                                                    </a>
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
                        <div class="card ">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <div class="center-align">
                                            <span class="card-title center-align">
                                                Leídas
                                            </span>
                                        </div>
                                        <div class="mailbox-list">
                                            <ul>
                                                @forelse($readNotifications as $readNotification)
                                                <li>
                                                    <a href="{{$readNotification->data['link']}}">
                                                        
                                                        <h5 class="mail-author">{{$readNotification->data['text']}}</h5>
                                                        <h4 class="mail-title"></h4>
                                                        <p class="hide-on-small-and-down mail-text"></p>
                                                        
                                                        <div class="position-top-right p f-12 mail-date">
                                                        <form method="POST" action="{{route('notifications.destroy',$readNotification->id)}}">
                                                            {{method_field('DELETE')}}
                                                            {{csrf_field()}}
                                                            <div class="mail-checkbox">
                                                            <h5 class="mail-author"><button class="position-top-right waves-effect waves-grey btn-flat m-t-xs">Marcar como leída</button></h5>
                                                        </div>
                                                    </form>
                                                    </div>
                                                    </a>
                                                </li>
                                                @empty
                                                    <li>
                                                    <a href="#">
                                                        
                                                        <h5 class="mail-author"></h5>
                                                        <h4 class="mail-title"></h4>
                                                        <p class="hide-on-small-and-down mail-text">No tienes Notificaciones</p>
                                                        <div class="position-top-right p f-12 mail-date"></div>
                                                    </a>
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
        </div>
    </div>
</main>
@endsection
