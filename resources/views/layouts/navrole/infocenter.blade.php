<li class="no-padding">
    <a class="collapsible-header waves-effect waves-grey {!! setActiveRouteActivePage('idea'), setActiveRouteActivePage('entrenamientos'), setActiveRouteActivePage('csibt') !!} {!! setActiveRoutePadding('idea'), setActiveRoutePadding('entrenamientos'), setActiveRoutePadding('csibt') !!}">
        <i class="material-icons {{ setActiveRouteActiveIcon('idea') }} {{ setActiveRouteActiveIcon('entrenamientos') }} {{ setActiveRouteActiveIcon('csibt') }}">lightbulb_outline</i>Ideas de Proyecto
        <i class="nav-drop-icon material-icons {{ setActiveRouteActiveIcon('idea') }} {{ setActiveRouteActiveIcon('entrenamientos') }} {{setActiveRouteActiveIcon('csibt')}}">keyboard_arrow_right</i>
    </a>
    <div class="collapsible-body">
        <ul>
        <li>
            <a href="{{route('idea.index')}} " class="{{setActiveRouteActivePage('idea')}}" rel="canonical" title="Ideas">
            <i class="material-icons {{setActiveRouteActiveIcon('idea')}}">lightbulb</i>Ideas
            </a>
        </li>
        <li>
            <a href="{{route('csibt')}}" class="{{setActiveRouteActivePage('csibt')}}" rel="canonical" title="CSIBT's">
            <i class="material-icons {{setActiveRouteActiveIcon('csibt')}}">gavel</i>CSIBT's
            </a>
        </li>
        </ul>
    </div>
</li>
<li class="no-padding {{setActiveRoute('charla')}}">
    <a href="{{route('charla')}}" class="{{setActiveRouteActivePage('charla')}}" rel="canonical" title="Charlas Informativas">
        <i class="material-icons {{setActiveRouteActiveIcon('charla')}}">record_voice_over</i>Charlas Informativas
    </a>
</li>
<li class="no-padding {{setActiveRoute('nodo')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('nodo')}}" href="{{route('nodo.index')}}" rel="canonical" title="Nodo">
        <i class="material-icons {{ setActiveRouteActiveIcon('nodo') }}">location_city</i>Nodo
    </a>
</li>
<li class="no-padding {{setActiveRoute('indicadores')}}">
    <a href="{{route('indicadores')}}" class="{{setActiveRouteActivePage('indicadores')}}">
        <i class="material-icons {{setActiveRouteActiveIcon('indicadores')}}">info_outline</i>Indicadores
    </a>
</li>
<li class="no-padding {{setActiveRoute('usuario')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('usuario')}}" href="{{route('usuario.index')}}" rel="canonical" title="Usuarios">
        <i class="material-icons {{ setActiveRouteActiveIcon('usuario') }}">supervised_user_circle</i>Usuarios
    </a>
</li>
<li class="no-padding {{setActiveRoute('empresa')}}">
    <a class="waves-effect waves-grey {{setActiveRouteActivePage('empresa')}}" href="{{route('empresa')}}" rel="canonical" title="Empresas">
        <i class="material-icons {{ setActiveRouteActiveIcon('empresa') }}">business_center</i>Empresas
    </a>
</li>
<li class="no-padding {{setActiveRoute('proyecto')}}">
    <a href="{{route('proyecto')}}" class="waves-effect waves-grey {{setActiveRouteActivePage('proyecto')}}" rel="canonical" title="Proyectos de Base Tecnológica">
        <i class="material-icons {{ setActiveRouteActiveIcon('proyecto') }}">library_books</i>PBT
    </a>
</li>
