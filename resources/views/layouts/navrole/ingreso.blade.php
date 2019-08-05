<li class="no-padding">
  <a class="collapsible-header waves-effect waves-grey {{ setActiveRouteActivePage('visitante') }} {{ setActiveRouteActivePage('ingreso') }} {{ setActiveRoutePadding('ingreso') }} {{ setActiveRoutePadding('visitante') }}">
    <i class="material-icons {{ setActiveRouteActiveIcon('visitante') }} {{ setActiveRouteActiveIcon('ingreso') }}">directions_walk</i>Ingresos
    <i class="nav-drop-icon material-icons {{ setActiveRouteActiveIcon('visitante') }} {{ setActiveRouteActiveIcon('ingreso') }}">keyboard_arrow_right</i>
  </a>
  <div class="collapsible-body">
    <ul>
      <li>
        <a href="{{route('ingreso')}}" class="{{setActiveRouteActivePage('ingreso')}}">
          <i class="material-icons {{setActiveRouteActiveIcon('ingreso')}}">transit_enterexit</i>Ingresos
        </a>
      </li>
      <li>
        <a href="{{route('visitante')}}" class="{{setActiveRouteActivePage('visitante')}}">
          <i class="material-icons {{setActiveRouteActiveIcon('visitante')}}">accessibility</i>Visitantes
        </a>
      </li>
    </ul>
  </div>
</li>
<li class="no-padding">
  <a href="" class="waves-effect waves-grey">
    <i class="material-icons">description</i>Reportes
  </a>
</li>