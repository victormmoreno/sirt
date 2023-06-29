<li class="no-padding {{setActiveRoute('nodo')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('nodo')}}" href="{{route('nodo.index')}}" rel="canonical" title="Nodo">
        <i class="material-icons {{ setActiveRouteActiveIcon('nodo') }}">location_city</i>Nodo
    </a>
</li>
<li class="no-padding {{setActiveRoute('usoinfraestructura')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('usoinfraestructura')}}" href="{{route('usoinfraestructura.index')}}" rel="canonical" title="Asesorias y usos">
        <i class="material-icons {{setActiveRouteActiveIcon('usoinfraestructura')}}">domain</i>Asesorias y usos
    </a>
</li>
<li class="no-padding">
    <a class="collapsible-header waves-effect waves-grey {!! setActiveRouteActivePage('equipo'), setActiveRouteActivePage('mantenimiento')!!} {!! setActiveRoutePadding('equipo'),  setActiveRoutePadding('mantenimiento')!!}">
        <i class="material-icons {{ setActiveRouteActiveIcon('equipo'),  setActiveRouteActiveIcon('mantenimiento')}}">account_balance_wallet</i>Equipos
        <i class="nav-drop-icon material-icons {{ setActiveRouteActiveIcon('equipo'), setActiveRouteActiveIcon('mantenimiento') }}">keyboard_arrow_right</i>
    </a>
    <div class="collapsible-body">
        <ul>
        <li>
            <a href="{{route('equipo.index')}}" class="{{setActiveRouteActivePage('equipo') }}" rel="canonical" title="Equipos">
            <i class="material-icons {{setActiveRouteActiveIcon('equipo')}}">account_balance_wallet</i>
            Equipos</a>
        </li>
        <li>
            <a href="{{route('mantenimiento.index')}}" class="{{setActiveRouteActivePage('mantenimiento')}}" rel="canonical" title="Mantenimientos">
            <i class="material-icons {{setActiveRouteActiveIcon('mantenimiento')}}">settings_applications</i>
            Mantenimientos</a>
        </li>
        </ul>
    </div>
</li>
