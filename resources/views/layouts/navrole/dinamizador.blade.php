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
{{-- <li class="no-padding">
  <a class="waves-effect waves-grey" href="">
    <i class="material-icons">settings_input_svideo</i>Costos Administrativos
  </a>
</li> --}}
<li class="no-padding">
  <a class="waves-effect waves-grey" href="">
    <i class="material-icons">filter_center_focus</i>Sublineas
  </a>
</li>
<li class="no-padding">
  <a class="collapsible-header waves-effect waves-grey {{setActiveRouteActivePage('csibt')}} {{ setActiveRouteActivePage('idea') }} {{ setActiveRouteActivePage('entrenamientos') }} {{setActiveRouteActivePage('idea')}} {{setActiveRouteActivePage('entrenamientos')}} {{setActiveRouteActivePage('entrenamientos/create')}}">
    <i class="material-icons {{ setActiveRouteActiveIcon('csibt') }} {{ setActiveRouteActiveIcon('idea') }} {{ setActiveRouteActiveIcon('entrenamientos') }} {{ setActiveRouteActiveIcon('entrenamientos/create') }}">lightbulb_outline</i>Ideas de Proyecto
    <i class="nav-drop-icon material-icons {{ setActiveRouteActiveIcon('csibt') }} {{ setActiveRouteActiveIcon('idea') }} {{ setActiveRouteActiveIcon('entrenamientos') }} {{ setActiveRouteActiveIcon('entrenamientos/create') }}">keyboard_arrow_right</i>
  </a>
  <div class="collapsible-body">
    <ul>
      <li>
        <a href="{{route('idea.ideas')}}" class="{{setActiveRouteActivePage('idea')}}">
          <i class="material-icons {{setActiveRouteActiveIcon('idea')}}">lightbulb</i>Ideas
        </a>
      </li>
      <li>
        <a href="{{route('entrenamientos')}}" class="{{setActiveRouteActivePage('entrenamientos')}} {{setActiveRouteActivePage('entrenamientos/create')}}">
          <i class="material-icons {{setActiveRouteActiveIcon('entrenamientos')}} {{setActiveRouteActiveIcon('entrenamientos/create')}}">library_books</i>Entrenamientos
        </a>
      </li>
      <li class="no-padding">
        <a href="{{route('csibt')}}" class="{{setActiveRouteActivePage('csibt')}} {{setActiveRouteActivePage('csibt/create')}}">
          <i class="material-icons {{setActiveRouteActiveIcon('csibt')}} {{setActiveRouteActiveIcon('csibt/create')}}">gavel</i>CSIBT's
        </a>
      </li>
    </ul>
  </div>
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
{{-- <li class="no-padding">
  <a class="waves-effect waves-grey" href="">
    <i class="material-icons">local_drink</i>Laboratorios
  </a>
</li> --}}
{{-- <li class="no-padding">
  <a class="waves-effect waves-grey" href="">
    <i class="material-icons">trending_down</i>Depreciación
  </a>
</li> --}}
{{-- <li class="no-padding">
  <a class="waves-effect waves-grey" href="">
    <i class="material-icons">build</i>Mantenimiento
  </a>
</li> --}}
{{-- <li class="no-padding">
  <a class="waves-effect waves-grey" href="">
    <i class="material-icons">local_library</i>Materiales de Formación
  </a>
</li> --}}
{{-- <li class="no-padding">
  <a class="waves-effect waves-grey" href="">
    <i class="material-icons">attach_money</i>Costos
  </a>
</li> --}}
{{-- <li class="no-padding">
  <a class="waves-effect waves-grey" href="">
    <i class="material-icons">show_chart</i>Indicadores
  </a>
</li> --}}
{{-- <li class="no-padding">
  <a class="waves-effect waves-grey" href="">
    <i class="material-icons">search</i>Seguimiento
  </a>
</li> --}}
{{-- <li class="no-padding">
  <a class="collapsible-header waves-effect waves-grey">
    <i class="material-icons">description</i> Reportes<i class="nav-drop-icon material-icons">keyboard_arrow_right</i>
  </a>
  <div class="collapsible-body">
    <ul>
      <li>
        <a href="">
          Infocenter
        </a>
      </li>
      <li>
        <a href="">
          Ingresos
        </a>
      </li>
      <li>
        <a href="">
          Gestor
        </a>
      </li>
      <li>
        <a href="">
          Dinamizador
        </a>
      </li>
    </ul>
  </div>
</li> --}}
