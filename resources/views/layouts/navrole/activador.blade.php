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
                        <i class="material-icons {{setActiveRouteActiveIcon('tipoarticulaciones')}}">library_books</i>{{__('articulation-type')}}
                    </a>
                </li>
            @endcan
            @can('index', App\Models\ArticulationSubtype::class)
                <li class="no-padding">
                    <a href="{{route('tiposubarticulaciones.index')}}" class="{{setActiveRouteActivePage('tiposubarticulaciones')}}" rel="canonical" title="Tipos subarticulaciones">
                        <i class="material-icons {{setActiveRouteActiveIcon('tiposubarticulaciones')}}">gavel</i>{{__('articulation-subtype')}}
                    </a>
                </li>
            @endcan
        </ul>
    </div>
</li>
