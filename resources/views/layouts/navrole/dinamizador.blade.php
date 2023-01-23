<li class="no-padding {{setActiveRoute('usuario')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('usuario')}}" href="{{route('usuario.index')}}" rel="canonical" title="Usuarios">
        <i class="material-icons {{ setActiveRouteActiveIcon('usuario') }}">supervised_user_circle</i>Usuarios
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
            <a href="{{route('idea.index')}}" class="{{setActiveRouteActivePage('idea')}}" rel="canonical" title="Ideas">
            <i class="material-icons {{setActiveRouteActiveIcon('idea')}}">lightbulb</i>Ideas
            </a>
        </li>
        <li>
            <a href="{{route('entrenamientos')}}" class="{{setActiveRouteActivePage('entrenamientos')}}" rel="canonical" title="Taller de fortalecimiento">
            <i class="material-icons {{setActiveRouteActiveIcon('entrenamientos')}}">library_books</i>Taller de fortalecimiento
            </a>
        </li>
        <li class="no-padding">
            <a href="{{route('csibt')}}" class="{{setActiveRouteActivePage('csibt')}}" rel="canonical" title="CSIBT's">
            <i class="material-icons {{setActiveRouteActiveIcon('csibt')}}">gavel</i>CSIBT's
            </a>
        </li>
        </ul>
    </div>
</li>
<li class="no-padding {{setActiveRoute('proyecto')}}">
    <a href="{{route('proyecto')}}" class="waves-effect waves-grey {{setActiveRouteActivePage('proyecto')}}" rel="canonical" title="Proyectos de Base Tecnológica">
        <i class="material-icons {{ setActiveRouteActiveIcon('proyecto') }}">library_books</i>Proyectos
    </a>
</li>
@can('index', App\Models\ArticulationStage::class)
    <li class="no-padding {{setActiveRoute('etapa-articulaciones')}}">
        <a href="{{route('articulation-stage')}}" class="{{setActiveRouteActivePage('etapa-articulaciones')}}" rel="canonical" title="{{__('articulation-stage')}}">
            <i class="material-icons {{setActiveRouteActiveIcon('etapa-articulaciones')}}">autorenew</i>{{__('articulation-stage')}}
        </a>
    </li>
@endcan
<li class="no-padding {{setActiveRoute('nodo')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('nodo')}}" href="{{route('nodo.index')}}" rel="canonical" title="Nodo">
        <i class="material-icons {{ setActiveRouteActiveIcon('nodo') }}">location_city</i>Nodo
    </a>
</li>
<li class="{!! setActiveRoute('costos-administrativos') !!}">
    <a class="waves-effect waves-grey {!! setActiveRouteActivePage('costos-administrativos') !!}" href="{{route('costoadministrativo.index')}}" rel="canonical" title="Costos Administrativos">
        <i class="material-icons {!! setActiveRouteActiveIcon('costos-administrativos') !!}">settings_input_svideo</i>Costos Administrativos
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
<li class="no-padding {{setActiveRoute('costos')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('costos')}}" href="{{route('costos')}}" rel="canonical" title="Costos">
        <i class="material-icons {{setActiveRouteActiveIcon('costos')}}">attach_money</i>Costos
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
    <a class="{{setActiveRouteActivePage('empresa')}}" href="{{route('empresa')}}" rel="canonical" title="Empresas">
        <i class="material-icons {{setActiveRouteActiveIcon('empresa')}} ">business_center</i>Empresas
    </a>
</li>
