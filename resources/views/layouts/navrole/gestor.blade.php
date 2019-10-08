<li class="no-padding {{setActiveRoute('nodo')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('nodo')}}" href="{{route('nodo.index')}}">
    <i class="material-icons {{ setActiveRouteActiveIcon('nodo') }}">location_city</i>Nodo
  </a>
</li>
<li class="no-padding {{setActiveRoute('usuario')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('usuario')}}" href="{{route('usuario.index')}}">
    <i class="material-icons {{ setActiveRouteActiveIcon('usuario') }}">supervised_user_circle</i>Talentos
  </a>
</li>

<li class="no-padding {{setActiveRoute('proyecto')}}">
  <a href="{{route('proyecto')}}" class="waves-effect waves-grey {{setActiveRouteActivePage('proyecto')}}">
    <i class="material-icons {{ setActiveRouteActiveIcon('proyecto') }}">library_books</i>Proyectos de Base Tecnológica
  </a>
</li>
<li class="no-padding {{setActiveRoute('articulacion')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('articulacion')}}" href="{{route('articulacion')}}">
    <i class="material-icons {{ setActiveRouteActiveIcon('articulacion') }}">autorenew</i>Articulaciones
  </a>
</li>
<li class="{!! setActiveRoute('edt') !!}">
  <a class="waves-effect waves-grey {!! setActiveRouteActivePage('edt') !!}" href="{{route('edt')}}">
  <i class="material-icons {!! setActiveRouteActiveIcon('edt') !!}">record_voice_over</i>EDT's
  </a>
</li>
<li class="no-padding {{setActiveRoute('usoinfraestructura')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('usoinfraestructura')}}" href="{{route('usoinfraestructura.index')}}">
    <i class="material-icons {{setActiveRouteActiveIcon('usoinfraestructura')}}">domain</i>Usos de infraestructura
  </a>
</li>
<li class="no-padding  ">
  <a class="collapsible-header waves-effect waves-grey {!! setActiveRouteActivePage('equipo'), setActiveRouteActivePage('mantenimiento')!!} {!! setActiveRoutePadding('equipo'),  setActiveRoutePadding('mantenimiento')!!}">
    <i class="material-icons {{ setActiveRouteActiveIcon('equipo'),  setActiveRouteActiveIcon('mantenimiento')}}">account_balance_wallet</i>Equipos
    <i class="nav-drop-icon material-icons {{ setActiveRouteActiveIcon('equipo'), setActiveRouteActiveIcon('mantenimiento') }}">keyboard_arrow_right</i>
  </a>
  <div class="collapsible-body">
    <ul>
      <li>
        <a href="{{route('equipo.index')}}" class="{{setActiveRouteActivePage('equipo') }}">
          <i class="material-icons {{setActiveRouteActiveIcon('equipo')}}">account_balance_wallet</i>
        Equipos</a>
      </li>
      <li>
        <a href="{{route('mantenimiento.index')}}" class="{{setActiveRouteActivePage('mantenimiento')}}">
          <i class="material-icons {{setActiveRouteActiveIcon('mantenimiento')}}">settings_applications</i>
        Mantenimientos</a>
      </li>
    </ul>
  </div>
</li>
<li class="no-padding {{setActiveRoute('empresa')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('empresa')}}" href="{{route('empresa')}}">
    <i class="material-icons {{ setActiveRouteActiveIcon('empresa') }}">business_center</i>Empresas
  </a>
</li>
<li class="no-padding {{setActiveRoute('grupo')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('grupo')}}" href="{{route('grupo')}}">
    <i class="material-icons {{setActiveRouteActiveIcon('grupo')}}">group_work</i>Grupos de Investigación
  </a>
</li>
{{-- <li class="no-padding">
  <a class="waves-effect waves-grey" href="">
    <i class="material-icons">attach_money</i>Costos
  </a>
</li> --}}
<li class="no-padding">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('idea')}}" href="{{route('idea.ideas')}}">
    <i class="material-icons {{ setActiveRouteActiveIcon('idea') }}">lightbulb</i>Ideas
  </a>
</li>
<li class="no-padding">
  <a href="{{route('csibt')}}" class="{{setActiveRouteActivePage('csibt')}}">
    <i class="material-icons {{setActiveRouteActiveIcon('csibt')}}">gavel</i>CSIBT's
  </a>
</li>
