@can('index', App\User::class)
<li class="no-padding {{setActiveRoute('usuario')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('usuario')}}" href="{{route('usuario.index')}}" rel="canonical" title="Usuarios">
        <i class="material-icons {{ setActiveRouteActiveIcon('usuario') }}">supervised_user_circle</i>Usuarios
    </a>
</li>
@endcan
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
<li class="no-padding">
    <a class="collapsible-header waves-effect waves-grey  {{setActiveRouteActivePage('etapa-articulaciones')}} {{ setActiveRouteActivePage('tipoarticulaciones') }} {{ setActiveRouteActivePage('tiposubarticulaciones') }} {!! setActiveRoutePadding('etapa-articulaciones'),setActiveRoutePadding('tipoarticulaciones'), setActiveRoutePadding('tiposubarticulaciones') !!}">
        <i class="material-icons {{ setActiveRouteActiveIcon('etapa-articulaciones') }} {{ setActiveRouteActiveIcon('tipoarticulaciones') }} {{ setActiveRouteActiveIcon('tiposubarticulaciones') }}">autorenew</i>Articulaciones
        <i class="nav-drop-icon material-icons {{ setActiveRouteActiveIcon('etapa-articulaciones') }} {{ setActiveRouteActiveIcon('tipoarticulaciones') }} {{ setActiveRouteActiveIcon('tiposubarticulaciones') }}">keyboard_arrow_right</i>
    </a>
    <div class="collapsible-body">
        <ul>
            @can('index', App\Models\ArticulationStage::class)
                <li>
                    <a href="{{route('articulation-stage')}} " class="{{setActiveRouteActivePage('etapa-articulaciones')}}" rel="canonical" title="">
                        <i class="material-icons {{setActiveRouteActiveIcon('etapa-articulaciones')}}">autorenew</i>{{__('articulation-stage')}}
                    </a>
                </li>
            @endcan
            @can('index', App\Models\ArticulationType::class)
                <li>
                    <a href="{{route('tipoarticulaciones.index')}}" class="{{setActiveRouteActivePage('tipoarticulaciones')}}" rel="canonical" title="Tipos articulaciones">
                        <i class="material-icons {{setActiveRouteActiveIcon('tipoarticulaciones')}}">settings</i>{{__('articulation-type')}}
                    </a>
                </li>
            @endcan
            @can('index', App\Models\ArticulationSubtype::class)
                <li class="no-padding">
                    <a href="{{route('tiposubarticulaciones.index')}}" class="{{setActiveRouteActivePage('tiposubarticulaciones')}}" rel="canonical" title="Tipos subarticulaciones">
                        <i class="material-icons {{setActiveRouteActiveIcon('tiposubarticulaciones')}}">settings</i>{{__('articulation-subtype')}}
                    </a>
                </li>
            @endcan
        </ul>
    </div>
</li>
<li class="no-padding {{setActiveRoute('materiales')}}">
    <a href="{{route('material.index')}}" class="{{setActiveRouteActivePage('materiales')}}" rel="canonical" title="Materiales de Formación">
        <i class="material-icons {{setActiveRouteActiveIcon('materiales')}}">local_library</i>Materiales de Formación
    </a>
</li>
<li class="no-padding">
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
<li class="no-padding {{setActiveRoute('charla')}}">
    <a href="{{route('charla')}}" class="{{setActiveRouteActivePage('charla')}}" rel="canonical" title="Charlas Informativas">
        <i class="material-icons {{setActiveRouteActiveIcon('charla')}}">record_voice_over</i>Charlas Informativas
    </a>
</li>
<li class="no-padding {{setActiveRoute('indicadores')}}">
    <a href="{{route('indicadores')}}" class="{{setActiveRouteActivePage('indicadores')}}">
        <i class="material-icons {{setActiveRouteActiveIcon('indicadores')}}">info_outline</i>Indicadores
    </a>
</li>
<li class="no-padding">
    <a class="collapsible-header waves-effect waves-grey {{setActiveRouteActivePage('csibt')}} {{ setActiveRouteActivePage('idea') }} {{ setActiveRouteActivePage('taller') }} {{setActiveRouteActivePage('idea')}} {{setActiveRouteActivePage('taller')}} {{setActiveRouteActivePage('taller/create')}}  {!! setActiveRoutePadding('idea'),setActiveRoutePadding('taller'), setActiveRoutePadding('csibt') !!}">
        <i class="material-icons {{ setActiveRouteActiveIcon('csibt') }} {{ setActiveRouteActiveIcon('idea') }} {{ setActiveRouteActiveIcon('taller') }} {{ setActiveRouteActiveIcon('taller/create') }}">lightbulb_outline</i>Ideas de Proyecto
        <i class="nav-drop-icon material-icons {{ setActiveRouteActiveIcon('csibt') }} {{ setActiveRouteActiveIcon('idea') }} {{ setActiveRouteActiveIcon('taller') }} {{ setActiveRouteActiveIcon('taller/create') }}">keyboard_arrow_right</i>
    </a>
    <div class="collapsible-body">
        <ul>
        <li>
            <a href="{{route('idea.index')}} " class="{{setActiveRouteActivePage('idea')}}" rel="canonical" title="Ideas">
            <i class="material-icons {{setActiveRouteActiveIcon('idea')}}">lightbulb</i>Ideas
            </a>
        </li>
        <li>
            <a href="{{route('taller')}}" class="{{setActiveRouteActivePage('taller')}} {{setActiveRouteActivePage('taller/create')}}" rel="canonical" title="taller">
            <i class="material-icons {{setActiveRouteActiveIcon('taller')}} {{setActiveRouteActiveIcon('taller/create')}}">library_books</i>Taller de fortalecimiento
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
{{--
<li class="no-padding {{setActiveRoute('seguimiento')}}">
    <a href="{{route('seguimiento')}}" class="{{setActiveRouteActivePage('seguimiento')}}" rel="canonical" title="Seguimiento">
        <i class="material-icons {{setActiveRouteActiveIcon('seguimiento')}}">search</i>Seguimiento
    </a>
</li>--}}

<li class="no-padding {{setActiveRoute('usoinfraestructura')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('usoinfraestructura')}}" href="{{route('usoinfraestructura.index')}}" rel="canonical" title="Asesorias y usos">
        <i class="material-icons {{setActiveRouteActiveIcon('usoinfraestructura')}}">domain</i>Asesorias y usos
    </a>
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
