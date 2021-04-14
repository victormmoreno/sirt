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
      </li> --}}
      <li>
        <a href="{{route('csibt')}}" class="{{setActiveRouteActivePage('csibt')}}" rel="canonical" title="CSIBT's">
          <i class="material-icons {{setActiveRouteActiveIcon('csibt')}}">gavel</i>CSIBT's
        </a>
      </li>
    </ul>
  </div>
</li>
<li class="no-padding {{setActiveRoute('charla')}}">
  <a href="{{route('charla')}}" class="{{setActiveRouteActivePage('charla')}}" rel="canonical" title="Charlas Informativas">
    <i class="material-icons {{setActiveRouteActiveIcon('charla')}}">record_voice_over</i>Charlas Informativas
  </a>
</li>
<li class="no-padding {{setActiveRoute('nodo')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('nodo')}}" href="{{route('nodo.index')}}" rel="canonical" title="Nodo">
      <i class="material-icons {{ setActiveRouteActiveIcon('nodo') }}">location_city</i>Nodo
    </a>
</li>
<li class="no-padding {{setActiveRoute('usuario')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('usuario')}}" href="{{route('usuario.index')}}" rel="canonical" title="Usuarios">
      <i class="material-icons {{ setActiveRouteActiveIcon('usuario') }}">supervised_user_circle</i>Usuarios
    </a>
</li>
<li class="no-padding {{setActiveRoute('proyecto')}}">
  <a href="{{route('proyecto')}}" class="waves-effect waves-grey {{setActiveRouteActivePage('proyecto')}}" rel="canonical" title="Proyectos de Base Tecnológica">
    <i class="material-icons {{ setActiveRouteActiveIcon('proyecto') }}">library_books</i>Proyectos de Base Tecnológica
  </a>
</li>
<li class="no-padding {{setActiveRoute('articulacion')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('articulacion')}}" href="{{route('articulacion')}}" rel="canonical" title="Articulaciones">
    <i class="material-icons {{ setActiveRouteActiveIcon('articulacion') }}">autorenew</i>Articulaciones con Grupos de Investigación
  </a>
</li>