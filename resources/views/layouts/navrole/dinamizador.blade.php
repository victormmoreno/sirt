<li class="no-padding {{setActiveRoute('nodo')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('nodo')}}" href="{{route('nodo.index')}}">
    <i class="material-icons {{ setActiveRouteActiveIcon('nodo') }}">location_city</i>Nodo
  </a>
</li>
<li class="{!! setActiveRoute('costos-administrativos') !!}">
  <a class="waves-effect waves-grey {!! setActiveRouteActivePage('costos-administrativos') !!}" href="{{route('costoadministrativo.index')}}">
  <i class="material-icons {!! setActiveRouteActiveIcon('costos-administrativos') !!}">settings_input_svideo</i>Costos Administrativos
  </a>
</li>
<li class="no-padding {{setActiveRoute('usuario')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('usuario')}}" href="{{route('usuario.index')}}">
    <i class="material-icons {{ setActiveRouteActiveIcon('usuario') }}">supervised_user_circle</i>Usuarios
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
  <i class="material-icons {!! setActiveRouteActiveIcon('edt') !!}">hearing</i>EDT's
  </a>
</li>
<li class="no-padding {{setActiveRoute('materiales')}}">
  <a href="{{route('material.index')}}" class="{{setActiveRouteActivePage('materiales')}}">
    <i class="material-icons {{setActiveRouteActiveIcon('materiales')}}">local_library</i>Materiales de Formación
  </a>
</li>
<li class="no-padding {{setActiveRoute('charla')}}">
  <a href="{{route('charla')}}" class="{{setActiveRouteActivePage('charla')}}">
    <i class="material-icons {{setActiveRouteActiveIcon('charla')}}">record_voice_over</i>Charlas Informativas
  </a>
</li>
<li class="no-padding {{setActiveRoute('grafico')}}">
  <a href="{{route('grafico')}}" class="{{setActiveRouteActivePage('grafico')}}">
    <i class="material-icons {{setActiveRouteActiveIcon('grafico')}}">insert_chart</i>Gráficos
  </a>
</li>
<li class="no-padding {{setActiveRoute('seguimiento')}}">
  <a href="{{route('seguimiento')}}" class="{{setActiveRouteActivePage('seguimiento')}}">
    <i class="material-icons {{setActiveRouteActiveIcon('seguimiento')}}">search</i>Seguimiento
  </a>
</li>
<li class="no-padding">
  <a class="collapsible-header waves-effect waves-grey {{ setActiveRouteActivePage('idea') }} {{ setActiveRouteActivePage('entrenamientos') }} {{setActiveRouteActivePage('csibt')}} {!! setActiveRoutePadding('idea'), setActiveRoutePadding('entrenamientos'), setActiveRoutePadding('csibt') !!}">
    <i class="material-icons {{ setActiveRouteActiveIcon('idea') }} {{ setActiveRouteActiveIcon('entrenamientos') }} {{ setActiveRouteActiveIcon('csibt') }}">lightbulb_outline</i>Ideas de Proyecto
    <i class="nav-drop-icon material-icons {{ setActiveRouteActiveIcon('idea') }} {{ setActiveRouteActiveIcon('entrenamientos') }} {{ setActiveRouteActiveIcon('csibt') }}">keyboard_arrow_right</i>
  </a>
  <div class="collapsible-body">
    <ul>
      <li>
        <a href="{{route('idea.ideas')}}" class="{{setActiveRouteActivePage('idea')}}">
          <i class="material-icons {{setActiveRouteActiveIcon('idea')}}">lightbulb</i>Ideas
        </a>
      </li>
      <li>
        <a href="{{route('entrenamientos')}}" class="{{setActiveRouteActivePage('entrenamientos')}}">
          <i class="material-icons {{setActiveRouteActiveIcon('entrenamientos')}}">library_books</i>Entrenamientos
        </a>
      </li>
      <li class="no-padding">
        <a href="{{route('csibt')}}" class="{{setActiveRouteActivePage('csibt')}}">
          <i class="material-icons {{setActiveRouteActiveIcon('csibt')}}">gavel</i>CSIBT's
        </a>
      </li>
    </ul>
  </div>
</li>
{{-- <li class="no-padding {{setActiveRoute('laboratorio')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('laboratorio')}}" href="{{route('laboratorio.index')}}">
    <i class="material-icons {{setActiveRouteActiveIcon('laboratorio')}}">local_drink</i>Laboratorios
  </a>
</li> --}}
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
<li class="no-padding {{setActiveRoute('usoinfraestructura')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('usoinfraestructura')}}" href="{{route('usoinfraestructura.index')}}">
    <i class="material-icons {{setActiveRouteActiveIcon('usoinfraestructura')}}">domain</i>Usos de infraestructura
  </a>
</li>
<li class="no-padding {{setActiveRoute('grupo')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('grupo')}}" href="{{route('grupo')}}">
    <i class="material-icons {{setActiveRouteActiveIcon('grupo')}}">group_work</i>Grupos de Investigación
  </a>
</li>
<li class="no-padding {{setActiveRoute('empresa')}}">
  <a class="{{setActiveRouteActivePage('empresa')}}" href="{{route('empresa')}}">
    <i class="material-icons {{setActiveRouteActiveIcon('empresa')}} ">business_center</i>Empresas
  </a>
</li>
