<li class="no-padding {{setActiveRoute('idea')}}">
    <a href="{{route('idea.index')}} " class="{{setActiveRouteActivePage('idea')}}" rel="canonical" title="Ideas">
        <i class="material-icons {{setActiveRouteActiveIcon('idea')}}">lightbulb</i>Ideas
    </a>
</li>
<li class="no-padding {{setActiveRoute('entrenamientos')}}">
    <a href="{{route('entrenamientos')}}" class="{{setActiveRouteActivePage('entrenamientos')}}" rel="canonical" title="Taller de Fortalecimiento">
        <i class="material-icons {{setActiveRouteActiveIcon('entrenamientos')}}">library_books</i>Taller de Fortalecimiento
    </a>
</li>
@can('index', App\Models\ArticulationStage::class)
<li class="no-padding {{setActiveRoute('etapa-articulaciones')}}">
    <a href="{{route('articulation-stage')}}" class="{{setActiveRouteActivePage('etapa-articulaciones')}}" rel="canonical" title="{{__('articulation-stage')}}">
        <i class="material-icons {{setActiveRouteActiveIcon('etapa-articulaciones')}}">autorenew</i>{{__('articulation-stage')}}
    </a>
</li>
@endcan
<li class="no-padding {{setActiveRoute('charla')}}">
    <a href="{{route('charla')}}" class="{{setActiveRouteActivePage('charla')}}" rel="canonical" title="Charlas Informativas">
        <i class="material-icons {{setActiveRouteActiveIcon('charla')}}">record_voice_over</i>Charlas Informativas
    </a>
</li>
<li class="no-padding {{setActiveRoute('usoinfraestructura')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('usoinfraestructura')}}" href="{{route('usoinfraestructura.index')}}" rel="canonical" title="Asesorias y usos">
        <i class="material-icons {{setActiveRouteActiveIcon('usoinfraestructura')}}">domain</i>Asesorias y usos
    </a>
</li>
@can('index', App\User::class)
<li class="no-padding {{setActiveRoute('usuario')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('usuario')}}" href="{{route('usuario.index')}}" rel="canonical" title="Usuarios">
        <i class="material-icons {{ setActiveRouteActiveIcon('usuario') }}">supervised_user_circle</i>Usuarios
    </a>
</li>
@endcan
<li class="no-padding {{setActiveRoute('empresa')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('empresa')}}" href="{{route('empresa')}}" rel="canonical" title="Empresas">
        <i class="material-icons {{ setActiveRouteActiveIcon('empresa') }}">business_center</i>Empresas
    </a>
</li>
