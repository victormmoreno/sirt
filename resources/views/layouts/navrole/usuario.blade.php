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
