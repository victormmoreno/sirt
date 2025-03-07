<li class="no-padding {{setActiveRoute('idea')}}">
    <a href="{{route('idea.index')}}" class="waves-effect waves-grey {{setActiveRouteActivePage('idea')}}">
        <i class="material-icons {{ setActiveRouteActiveIcon('idea') }}">lightbulb</i>Ideas
    </a>
</li>
<li class="no-padding {{setActiveRoute('empresa')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('empresa')}}" href="{{route('empresa')}}" rel="canonical" title="Empresas">
        <i class="material-icons {{setActiveRouteActiveIcon('empresa')}}">business_center</i>Empresas
    </a>
</li>
<li class="no-padding {{setActiveRoute('proyecto')}}">
    <a href="{{route('proyecto')}}" class="waves-effect waves-grey {{setActiveRouteActivePage('proyecto')}}">
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
<li class="no-padding {{setActiveRoute('asesorias')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('asesorias')}}" href="{{route('asesorias.index')}}" rel="canonical" title="Asesorias y usos">
        <i class="material-icons {{setActiveRouteActiveIcon('asesorias')}}">domain</i>Asesorias y usos
    </a>
</li>
