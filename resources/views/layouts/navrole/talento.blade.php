<li class="no-padding">
  <a class="collapsible-header waves-effect waves-grey {!! setActiveRouteActivePage('idea'), setActiveRouteActivePage('entrenamientos'), setActiveRouteActivePage('csibt') !!} {!! setActiveRoutePadding('idea'), setActiveRoutePadding('entrenamientos'), setActiveRoutePadding('csibt') !!}">
    <i class="material-icons {{ setActiveRouteActiveIcon('idea') }} {{ setActiveRouteActiveIcon('entrenamientos') }} {{ setActiveRouteActiveIcon('csibt') }}">lightbulb_outline</i>Ideas de Proyecto
    <i class="nav-drop-icon material-icons {{ setActiveRouteActiveIcon('idea') }} {{ setActiveRouteActiveIcon('entrenamientos') }} {{setActiveRouteActiveIcon('csibt')}}">keyboard_arrow_right</i>
  </a>
  <div class="collapsible-body">
    <ul>
      <li>
        <a href="{{route('idea.index')}} " class="{{setActiveRouteActivePage('idea')}}" rel="canonical" title="Ideas">
          <i class="material-icons {{setActiveRouteActiveIcon('idea')}}">lightbulb</i>Ideas
        </a>
      </li>
      {{-- <li>
        <a href="{{route('entrenamientos')}}" class="{{setActiveRouteActivePage('entrenamientos')}}" rel="canonical" title="Taller de Fortalecimiento">
          <i class="material-icons {{setActiveRouteActiveIcon('entrenamientos')}}">library_books</i>Taller de Fortalecimiento
        </a>
      </li>
      <li>
        <a href="{{route('csibt')}}" class="{{setActiveRouteActivePage('csibt')}}" rel="canonical" title="CSIBT's">
          <i class="material-icons {{setActiveRouteActiveIcon('csibt')}}">gavel</i>CSIBT's
        </a>
      </li> --}}
    </ul>
  </div>
</li>
<li class="no-padding {{setActiveRoute('proyecto')}}">
    <a href="{{route('proyecto')}}" class="waves-effect waves-grey {{setActiveRouteActivePage('proyecto')}}">
      <i class="material-icons {{ setActiveRouteActiveIcon('proyecto') }}">library_books</i>PBT
    </a>
  </li>
<li class="no-padding {{setActiveRoute('usoinfraestructura')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('usoinfraestructura')}}" href="{{route('usoinfraestructura.index')}}" rel="canonical" title="Usos de infraestructura">
    <i class="material-icons {{setActiveRouteActiveIcon('usoinfraestructura')}}">domain</i>Usos de infraestructura
  </a>
</li>