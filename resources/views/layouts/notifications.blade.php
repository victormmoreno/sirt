<ul class="dropdown-content notifications-dropdown" id="dropdown1">
    <li class="notificatoins-dropdown-container">
        <ul>
            <li class="notification-drop-title center">
                <div class="center">
                    Notificaciones
                </div>
            </li>
            <li class="divider" tabindex="-1">
            </li>
            @forelse (Auth::user()->unreadNotifications as $notification)
            <li>
                <a href="{{route('notifications.index')}}">
                    <div class="notification">
                        <div class="notification-icon circle {{ $notification->data['color'] }}">
                            <i class="material-icons">
                                {{ $notification->data["icon"] }}
                            </i>
                        </div>
                        <div class="notification-text">
                            <p>
                                {{ $notification->data["text"] }}
                            </p>
                            <span>
                                {{$notification->created_at->diffForHumans()}}
                            </span>
                        </div>
                    </div>
                </a>
            </li>
            @empty
            <li class="notification-drop-title">
                <div class="center">
                    <i class="large material-icons teal-text lighten-2 center ">
                        notifications_off
                    </i>
                    <p class="center-align">
                        No tienes notificationes
                    </p>
                </div>
            </li>
            @endforelse
            <li class="divider" tabindex="-1">
            </li>
            <li class="notification-drop-title">
                <a href="{{route('notifications.index')}}">
                    <div class="notification">
                        <div class="notification-icon circle cyan darken-3">
                            <i class="material-icons">
                                add_alert
                            </i>
                        </div>
                        <div class="notification-text">
                            <p>
                                Ver más notificationes
                            </p>
                        </div>
                    </div>
                </a>
            </li>
            {{-- @if(auth()->user()->unreadNotifications->isNotEmpty())
            <li class="notification-drop-title">
                <a href="{{route('notifications.index')}}" onclick="event.preventDefault(); document.getElementById('markasread-all-notifications').submit();">
                    <form action="{{route('notifications.markallnotificationsasread')}}" id="markasread-all-notifications" method="POST">
                        {{method_field('PATCH')}}
                    {{csrf_field()}}
                        <div class="notification">
                            <div class="notification-icon circle cyan darken-3 ">
                                <i class="material-icons">
                                    notifications_paused
                                </i>
                            </div>
                            <div class="notification-text">
                                <p>
                                    Marcar todo como leído
                                </p>
                            </div>
                        </div>
                    </form>
                </a>
            </li>
            <li class="notification-drop-title">
                <a href="{{route('notifications.index')}}" onclick="event.preventDefault(); document.getElementById('remove-all-notifications').submit();">
                    <form action="{{route('notifications.removeallnotifications')}}" id="remove-all-notifications" method="POST">
                        {{method_field('DELETE')}}
                    {{csrf_field()}}
                        <div class="notification">
                            <div class="notification-icon circle cyan darken-3">
                                <i class="material-icons">
                                    notifications_off
                                </i>
                            </div>
                            <div class="notification-text">
                                <p>
                                    Borrar todas las notificaciones
                                </p>
                            </div>
                        </div>
                    </form>
                </a>
            </li>
            @endif --}}
        </ul>
    </li>
</ul>