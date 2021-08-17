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
        <i class="material-icons {{ setActiveRouteActiveIcon('proyecto') }}">library_books</i>PBT
    </a>
</li>
<li class="no-padding {{setActiveRoute('articulacion')}}">
    <a href="{{ route('articulaciones.index') }}" class="{{setActiveRouteActivePage('articulacion')}}" rel="canonical" title="Articulaciones">
        <i class="material-icons {{setActiveRouteActiveIcon('articulacion')}}">autorenew</i>Articulaciones
    </a>
</li>
<li class="no-padding {{setActiveRoute('usoinfraestructura')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('usoinfraestructura')}}" href="{{route('usoinfraestructura.index')}}" rel="canonical" title="Usos de infraestructura">
        <i class="material-icons {{setActiveRouteActiveIcon('usoinfraestructura')}}">domain</i>Usos de infraestructura
    </a>
</li>
