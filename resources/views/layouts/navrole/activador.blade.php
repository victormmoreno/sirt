<li class="no-padding">
    <a class="collapsible-header waves-effect waves-grey {{setActiveRouteActivePage('articulaciones')}} {{ setActiveRouteActivePage('tipoarticulaciones') }} {{ setActiveRouteActivePage('tiposubarticulaciones') }} {!! setActiveRoutePadding('tiposubarticulaciones'),setActiveRoutePadding('tipoarticulaciones'), setActiveRoutePadding('articulaciones') !!}">
        <i class="material-icons {{ setActiveRouteActiveIcon('articulaciones') }} {{ setActiveRouteActiveIcon('tipoarticulaciones') }} {{ setActiveRouteActiveIcon('entrenamientos') }} {{ setActiveRouteActiveIcon('entrenamientos/create') }}">autorenew</i>Articulaciones
        <i class="nav-drop-icon material-icons {{ setActiveRouteActiveIcon('articulaciones') }} {{ setActiveRouteActiveIcon('tipoarticulaciones') }} {{ setActiveRouteActiveIcon('entrenamientos') }} {{ setActiveRouteActiveIcon('entrenamientos/create') }}">keyboard_arrow_right</i>
    </a>
    <div class="collapsible-body">
        <ul>
            @can('index', App\Models\ArticulationStage::class)
                <li>
                    <a href="{{route('articulation-stage')}} " class="{{setActiveRouteActivePage('articulaciones')}}" rel="canonical" title="">
                        <i class="material-icons {{setActiveRouteActiveIcon('articulaciones')}}">autorenew</i>{{__('articulation-stage')}}
                    </a>
                </li>
            @endcan
            <li>
                <a href="{{route('tipoarticulaciones.index')}}" class="{{setActiveRouteActivePage('tipoarticulaciones')}}" rel="canonical" title="Tipos articulaciones">
                    <i class="material-icons {{setActiveRouteActiveIcon('tipoarticulaciones')}}">library_books</i>Tipos de articulaciones
                </a>
            </li>
            @can('index', App\Models\ArticulationSubtype::class)
                <li class="no-padding">
                    <a href="{{route('tiposubarticulaciones.index')}}" class="{{setActiveRouteActivePage('tiposubarticulaciones')}}" rel="canonical" title="Tipos subarticulaciones">
                        <i class="material-icons {{setActiveRouteActiveIcon('tiposubarticulaciones')}}">gavel</i>Tipo de subarticulaciones
                    </a>
                </li>
            @endcan
        </ul>
    </div>
</li>
