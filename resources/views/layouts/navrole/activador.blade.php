<li class="no-padding {{setActiveRoute('usuario')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('usuario')}}" href="{{route('usuario.index')}}" rel="canonical" title="Usuarios">
        <i class="material-icons {{ setActiveRouteActiveIcon('usuario') }}">supervised_user_circle</i>Usuarios
    </a>
</li>
<li class="no-padding {{setActiveRoute('nodo')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('nodo')}}" href="{{route('nodo.index')}}" rel="canonical" title="Nodo">
        <i class="material-icons {{ setActiveRouteActiveIcon('nodo') }}">location_city</i>Nodo
    </a>
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
        <i class="material-icons {{setActiveRouteActiveIcon('proyecto')}}">library_books</i>Proyectos
    </a>
</li>
<li class="no-padding {{setActiveRoute('articulacion')}}">
    <a href="{{ route('articulaciones.index') }}" class="{{setActiveRouteActivePage('articulacion')}}" rel="canonical" title="Articulaciones">
        <i class="material-icons {{setActiveRouteActiveIcon('articulacion')}}">autorenew</i>Articulación PBT
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
<li class="no-padding {{setActiveRoute('seguimiento')}}">
    <a href="{{route('seguimiento')}}" class="{{setActiveRouteActivePage('seguimiento')}}" rel="canonical" title="Seguimiento">
        <i class="material-icons {{setActiveRouteActiveIcon('seguimiento')}}">search</i>Seguimiento
    </a>
</li>
<li class="no-padding {{setActiveRoute('indicadores')}}">
    <a href="{{route('indicadores')}}" class="{{setActiveRouteActivePage('indicadores')}}">
        <i class="material-icons {{setActiveRouteActiveIcon('indicadores')}}">info_outline</i>Indicadores
    </a>
</li>
<li class="no-padding">
    <a class="collapsible-header waves-effect waves-grey {{setActiveRouteActivePage('csibt')}} {{ setActiveRouteActivePage('idea') }} {{ setActiveRouteActivePage('talleres') }} {{setActiveRouteActivePage('idea')}} {{setActiveRouteActivePage('talleres')}} {{setActiveRouteActivePage('talleres/create')}}  {!! setActiveRoutePadding('idea'),setActiveRoutePadding('talleres'), setActiveRoutePadding('csibt') !!}">
        <i class="material-icons {{ setActiveRouteActiveIcon('csibt') }} {{ setActiveRouteActiveIcon('idea') }} {{ setActiveRouteActiveIcon('talleres') }} {{ setActiveRouteActiveIcon('talleres/create') }}">lightbulb_outline</i>Ideas de Proyecto
        <i class="nav-drop-icon material-icons {{ setActiveRouteActiveIcon('csibt') }} {{ setActiveRouteActiveIcon('idea') }} {{ setActiveRouteActiveIcon('talleres') }} {{ setActiveRouteActiveIcon('talleres/create') }}">keyboard_arrow_right</i>
    </a>
    <div class="collapsible-body">
        <ul>
        <li>
            <a href="{{route('idea.index')}} " class="{{setActiveRouteActivePage('idea')}}" rel="canonical" title="Ideas">
            <i class="material-icons {{setActiveRouteActiveIcon('idea')}}">lightbulb</i>Ideas
            </a>
        </li>
        <li>
            <a href="{{route('talleres')}}" class="{{setActiveRouteActivePage('talleres')}} {{setActiveRouteActivePage('talleres/create')}}" rel="canonical" title="talleres">
            <i class="material-icons {{setActiveRouteActiveIcon('talleres')}} {{setActiveRouteActiveIcon('talleres/create')}}">library_books</i>Taller de fortalecimiento
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
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('usoinfraestructura')}}" href="{{route('usoinfraestructura.index')}}" rel="canonical" title="Asesorias y usos">
        <i class="material-icons {{setActiveRouteActiveIcon('usoinfraestructura')}}">domain</i>Asesorias y usos
    </a>
</li>
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
<li class="no-padding {{setActiveRoute('noticias')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('noticias')}}" href="{{url('noticias')}}" title="Noticias">
        <i class="material-icons {{setActiveRouteActiveIcon('noticias')}}">local_library</i>Noticias
    </a>
</li>
