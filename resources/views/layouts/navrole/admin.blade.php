<li class="no-padding {{setActiveRoute('usuario')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('usuario')}}" href="{{route('usuario.index')}}" rel="canonical" title="Usuarios">
    <i class="material-icons {{ setActiveRouteActiveIcon('usuario') }}">supervised_user_circle</i>
  </a>
</li>
<li class="no-padding  ">
  <a class="collapsible-header waves-effect waves-grey {!! setActiveRouteActivePage('nodo')!!} {!! setActiveRoutePadding('nodo')!!}">
    <i class="material-icons {{ setActiveRouteActiveIcon('nodo') }}">location_city</i>Nodos
    <i class="nav-drop-icon material-icons {{ setActiveRouteActiveIcon('nodo'), setActiveRouteActiveIcon('costos-administrativos') }}">keyboard_arrow_right</i>
  </a>
  <div class="collapsible-body">
    <ul>
      <li>
        <a href="{{route('nodo.index')}}" class="{{setActiveRouteActivePage('nodo')}}" rel="canonical" title="Nodos">
          <i class="material-icons {{setActiveRouteActiveIcon('nodo')}}">domain</i>
        Nodos</a>
      </li>
      
      {{-- <li>
        <a href="">Mapa</a>
      </li> --}}
    </ul>
  </div>
</li>
<li class="no-padding {{setActiveRoute('costos-administrativos')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('costos-administrativos')}}" href="{{route('costoadministrativo.index')}}" rel="canonical" title="Costos Administrativos">
    <i class="material-icons {{ setActiveRouteActiveIcon('costos-administrativos') }}">settings_input_svideo</i>Costos Administrativos
  </a>
</li>
<li class="no-padding {{setActiveRoute('lineas')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('lineas')}}" href="{{route('lineas.index')}}" rel="canonical" title="Lineas Tecnológicas">
    <i class="material-icons {{ setActiveRouteActiveIcon('lineas') }}">linear_scale</i>Lineas Tecnológicas
  </a>
</li>
<li class="no-padding {{setActiveRoute('sublineas')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('sublineas')}}" href="{{route('sublineas.index')}}" rel="canonical" title="Sublineas">
    <i class="material-icons {{ setActiveRouteActiveIcon('sublineas') }}">linear_scale</i>Sublineas
  </a>
</li>
<li class="no-padding {{setActiveRoute('proyecto')}}">
  <a href="{{ route('proyecto') }}" class="{{setActiveRouteActivePage('proyecto')}}" rel="canonical" title="Proyectos de Base Tecnológica">
    <i class="material-icons {{setActiveRouteActiveIcon('proyecto')}}">library_books</i>Proyectos de Base Tecnológica
  </a>
</li>
<li class="no-padding {{setActiveRoute('articulacion')}}">
  <a href="{{ route('articulacion') }}" class="{{setActiveRouteActivePage('articulacion')}}" rel="canonical" title="Articulaciones">
    <i class="material-icons {{setActiveRouteActiveIcon('articulacion')}}">autorenew</i>Articulaciones
  </a>
</li>
<li class="{{ setActiveRoute('edt') }}">
  <a class="waves-effect waves-grey {{ setActiveRouteActivePage('edt') }}" href="{{route('edt')}}" rel="canonical" title="EDT's">
    <i class="material-icons {{ setActiveRouteActiveIcon('edt') }}">hearing</i>EDT's
  </a>
</li>
<li class="no-padding {{setActiveRoute('materiales')}}">
  <a href="{{route('material.index')}}" class="{{setActiveRouteActivePage('materiales')}}" rel="canonical" title="Materiales de Formación">
    <i class="material-icons {{setActiveRouteActiveIcon('materiales')}}">local_library</i>Materiales de Formación
  </a>
</li>
<li class="no-padding {{setActiveRoute('charla')}}">
  <a href="{{route('charla')}}" class="{{setActiveRouteActivePage('charla')}}" rel="canonical" title="Charlas Informativas">
    <i class="material-icons {{setActiveRouteActiveIcon('charla')}}">record_voice_over</i>Charlas Informativas
  </a>
</li>
<li class="no-padding {{setActiveRoute('grafico')}}">
  <a href="{{route('grafico')}}" class="{{setActiveRouteActivePage('grafico')}}" rel="canonical" title="Gráficos">
    <i class="material-icons {{setActiveRouteActiveIcon('grafico')}}">insert_chart</i>Gráficos
  </a>
</li>
<li class="no-padding">
  <a class="collapsible-header waves-effect waves-grey {{setActiveRouteActivePage('csibt')}} {{ setActiveRouteActivePage('idea') }} {{ setActiveRouteActivePage('entrenamientos') }} {{setActiveRouteActivePage('idea')}} {{setActiveRouteActivePage('entrenamientos')}} {{setActiveRouteActivePage('entrenamientos/create')}}  {!! setActiveRoutePadding('idea'),setActiveRoutePadding('entrenamientos'), setActiveRoutePadding('csibt') !!}">
    <i class="material-icons {{ setActiveRouteActiveIcon('csibt') }} {{ setActiveRouteActiveIcon('idea') }} {{ setActiveRouteActiveIcon('entrenamientos') }} {{ setActiveRouteActiveIcon('entrenamientos/create') }}">lightbulb_outline</i>Ideas de Proyecto
    <i class="nav-drop-icon material-icons {{ setActiveRouteActiveIcon('csibt') }} {{ setActiveRouteActiveIcon('idea') }} {{ setActiveRouteActiveIcon('entrenamientos') }} {{ setActiveRouteActiveIcon('entrenamientos/create') }}">keyboard_arrow_right</i>
  </a>
  <div class="collapsible-body">
    <ul>
      <li>
        <a href="{{route('idea.ideas')}} " class="{{setActiveRouteActivePage('idea')}}" rel="canonical" title="Ideas">
          <i class="material-icons {{setActiveRouteActiveIcon('idea')}}">lightbulb</i>Ideas
        </a>
      </li>
      <li>
        <a href="{{route('entrenamientos')}}" class="{{setActiveRouteActivePage('entrenamientos')}} {{setActiveRouteActivePage('entrenamientos/create')}}" rel="canonical" title="Entrenamientos">
          <i class="material-icons {{setActiveRouteActiveIcon('entrenamientos')}} {{setActiveRouteActiveIcon('entrenamientos/create')}}">library_books</i>Entrenamientos
        </a>
      </li>
      <li class="no-padding">
        <a href="{{route('csibt')}}" class="{{setActiveRouteActivePage('csibt')}} {{setActiveRouteActivePage('csibt/create')}}" rel="canonical" title="CSIBT's">
          <i class="material-icons {{setActiveRouteActiveIcon('csibt')}} {{setActiveRouteActiveIcon('csibt/create')}}">gavel</i>CSIBT's
        </a>
      </li>
    </ul>
  </div>
</li>
<li class="no-padding {{setActiveRoute('usoinfraestructura')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('usoinfraestructura')}}" href="{{route('usoinfraestructura.index')}}" rel="canonical" title="Usos de infraestructura">
    <i class="material-icons {{setActiveRouteActiveIcon('usoinfraestructura')}}">domain</i>Usos de infraestructura
  </a>
</li>
{{-- <li class="no-padding {{setActiveRoute('laboratorio')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('laboratorio')}}" href="{{route('laboratorio.index')}}">
    <i class="material-icons {{setActiveRouteActiveIcon('laboratorio')}}">local_drink</i>Laboratorios
  </a>
</li> --}}
<li class="no-padding  ">
  <a class="collapsible-header waves-effect waves-grey {!! setActiveRouteActivePage('equipo'), setActiveRouteActivePage('mantenimiento')!!} {!! setActiveRoutePadding('equipo'),  setActiveRoutePadding('mantenimiento')!!}" rel="canonical" title="Equipos">
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
<li class="no-padding {{setActiveRoute('grupo')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('grupo')}}" href="{{route('grupo')}}" rel="canonical" title="Grupos de Investigación">
    <i class="material-icons {{setActiveRouteActiveIcon('grupo')}}">group_work</i>Grupos de Investigación
  </a>
</li>
<li class="no-padding {{setActiveRoute('empresa')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('empresa')}}" href="{{route('empresa')}}" rel="canonical" title="Empresas">
    <i class="material-icons {{setActiveRouteActiveIcon('empresa')}}">business_center</i>Empresas
  </a>
</li>
{{-- <li class="no-padding">
  <a class="collapsible-header waves-effect waves-grey {{ setActiveRouteActivePage('visitante'), setActiveRouteActivePage('ingreso') }} {{ setActiveRoutePadding('visitante'), setActiveRoutePadding('ingreso') }}">
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
</li> --}}
{{-- <li class="no-padding">
  <a class="waves-effect waves-grey" href="">
    <i class="material-icons">local_library</i>Materiales de Formación
  </a>
</li>
<li class="no-padding">
  <a class="waves-effect waves-grey" href="">
    <i class="material-icons">attach_money</i>Costos
  </a>
</li>
<li class="no-padding">
  <a class="waves-effect waves-grey" href="">
    <i class="material-icons">show_chart</i>Indicadores
  </a>
</li> --}}
