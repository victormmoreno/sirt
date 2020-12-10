<li class="no-padding {{setActiveRoute('nodo')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('nodo')}}" href="{{route('nodo.index')}}" rel="canonical" title="Nodo">
    <i class="material-icons {{ setActiveRouteActiveIcon('nodo') }}">location_city</i>Nodo
  </a>
</li>
{{-- <li class="no-padding {{setActiveRoute('usuario')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('usuario')}}" href="{{route('usuario.index')}}" rel="canonical" title="Talentos">
    <i class="material-icons {{ setActiveRouteActiveIcon('usuario') }}">supervised_user_circle</i>Talentos
  </a>
</li> --}}

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
{{-- <li class="no-padding {{setActiveRoute('intervencion')}}">
  <a href="{{ route('intervencion.index') }}" class="{{setActiveRouteActivePage('intervencion')}}" rel="canonical" title="Articulaciones">
    <i class="material-icons {{setActiveRouteActiveIcon('intervencion')}}">autorenew</i>Intervención a Empresas
  </a>
</li> --}}
<li class="{!! setActiveRoute('edt') !!}">
  <a class="waves-effect waves-grey {!! setActiveRouteActivePage('edt') !!}" href="{{route('edt')}}" rel="canonical" title="EDT's">
  <i class="material-icons {!! setActiveRouteActiveIcon('edt') !!}">hearing</i>EDT's
  </a>
</li>
<li class="no-padding {{setActiveRoute('materiales')}}">
  <a href="{{route('material.index')}}" class="{{setActiveRouteActivePage('materiales')}}" rel="canonical" title="Materiales de Formación">
    <i class="material-icons {{setActiveRouteActiveIcon('materiales')}}">local_library</i>Materiales de Formación
  </a>
</li>
<li class="no-padding {{setActiveRoute('usoinfraestructura')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('usoinfraestructura')}}" href="{{route('usoinfraestructura.index')}}" rel="canonical" title="Asesorias y usos">
    <i class="material-icons {{setActiveRouteActiveIcon('usoinfraestructura')}}">domain</i>Asesorias y usos
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
<li class="no-padding {{setActiveRoute('empresa')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('empresa')}}" href="{{route('empresa')}}" rel="canonical" title="Empresas">
    <i class="material-icons {{ setActiveRouteActiveIcon('empresa') }}">business_center</i>Empresas
  </a>
</li>
<li class="no-padding {{setActiveRoute('grupo')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('grupo')}}" href="{{route('grupo')}}" rel="canonical" title="Grupos de Investigación">
    <i class="material-icons {{setActiveRouteActiveIcon('grupo')}}">group_work</i>Grupos de Investigación
  </a>
</li>
<li class="no-padding {{setActiveRoute('indicadores')}}">
  <a href="{{route('indicadores')}}" class="{{setActiveRouteActivePage('indicadores')}}">
    <i class="material-icons {{setActiveRouteActiveIcon('indicadores')}}">info_outline</i>Indicadores
  </a>
</li>
<li class="no-padding {{setActiveRoute('seguimiento')}}">
  <a href="{{route('seguimiento')}}" class="{{setActiveRouteActivePage('seguimiento')}}" rel="canonical" title="Seguimiento">
    <i class="material-icons {{setActiveRouteActiveIcon('seguimiento')}}">search</i>Seguimiento
  </a>
</li>
<li class="no-padding {{setActiveRoute('costos')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('costos')}}" href="{{route('costos')}}" rel="canonical" title="Costos">
    <i class="material-icons {{setActiveRouteActiveIcon('costos')}}">attach_money</i>Costos
  </a>
</li>
<li class="no-padding">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('idea')}}" href="{{route('idea.index')}}" rel="canonical" title="Ideas">
    <i class="material-icons {{ setActiveRouteActiveIcon('idea') }}">lightbulb</i>Ideas
  </a>
</li>
<li class="no-padding">
  <a href="{{route('csibt')}}" class="{{setActiveRouteActivePage('csibt')}}" rel="canonical" title="CSIBT's">
    <i class="material-icons {{setActiveRouteActiveIcon('csibt')}}">gavel</i>CSIBT's
  </a>
</li>
