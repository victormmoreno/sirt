
  
  <li class="no-padding">
    <a class="collapsible-header waves-effect waves-grey {{setActiveRouteActivePage('csibt')}} {{setActiveRouteActivePage('csibt/create')}} {{ setActiveRoutePadding('idea') }} {{ setActiveRoutePadding('entrenamientos') }} {{setActiveRouteActivePage('entrenamientos')}} {{setActiveRouteActivePage('entrenamientos/create')}}">
      <i class="material-icons {{ setActiveRouteActiveIcon('idea') }} {{ setActiveRouteActiveIcon('entrenamientos') }} {{ setActiveRouteActiveIcon('csibt') }} {{ setActiveRouteActiveIcon('csibt/create') }} {{ setActiveRouteActiveIcon('entrenamientos/create') }}">lightbulb_outline</i>Ideas de Proyecto
      <i class="nav-drop-icon material-icons {{setActiveRouteActiveIcon('csibt')}} {{setActiveRouteActiveIcon('csibt/create')}} {{ setActiveRouteActiveIcon('idea') }} {{ setActiveRouteActiveIcon('entrenamientos') }} {{ setActiveRouteActiveIcon('entrenamientos/create') }}">keyboard_arrow_right</i>
    </a>
    <div class="collapsible-body">
      <ul>
        <li>
          <a href="{{route('idea.ideas')}} " class="{{setActiveRouteActivePage('idea')}}">
            <i class="material-icons {{setActiveRouteActiveIcon('idea')}}">lightbulb</i>Ideas
          </a>
        </li>
        <li>
          <a href="{{route('entrenamientos')}}" class="{{setActiveRouteActivePage('entrenamientos')}} {{setActiveRouteActivePage('entrenamientos/create')}}">
            <i class="material-icons {{setActiveRouteActiveIcon('entrenamientos')}} {{setActiveRouteActiveIcon('entrenamientos/create')}}">library_books</i>Entrenamientos
          </a>
        </li>
        <li>
          <a href="{{route('csibt')}}" class="{{setActiveRouteActivePage('csibt')}} {{setActiveRouteActivePage('csibt/create')}}">
            <i class="material-icons {{setActiveRouteActiveIcon('csibt')}} {{setActiveRouteActiveIcon('csibt/create')}}">gavel</i>CSIBT's
          </a>
        </li>
      </ul>
    </div>
  </li>
  <li class="no-padding">
    <a href="">
      <i class="material-icons">record_voice_over</i>Charlas Informativas
    </a>
  </li>
  <li class="no-padding">
    <a href="">
      <i class="material-icons">description</i>Reportes
    </a>
  </li>

