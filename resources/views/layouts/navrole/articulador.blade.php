<li class="no-padding {{ setActiveRoute('asesorias') }}">
    <a class="waves-effect waves-grey {{ setActiveRouteActivePage('asesorias') }}" href="{{ route('asesorias.index') }}"
        rel="canonical" title="Asesorias y usos">
        <i class="material-icons {{ setActiveRouteActiveIcon('asesorias') }}">domain</i>Asesorias y usos
    </a>
</li>
@can('index', App\Models\ArticulationStage::class)
    <li class="no-padding {{ setActiveRoute('etapa-articulaciones') }}">
        <a href="{{ route('articulation-stage') }}" class="{{ setActiveRouteActivePage('etapa-articulaciones') }}"
            rel="canonical" title="{{ __('articulation-stage') }}">
            <i
                class="material-icons {{ setActiveRouteActiveIcon('etapa-articulaciones') }}">autorenew</i>{{ __('articulation-stage') }}
        </a>
    </li>
@endcan
<li class="no-padding {{ setActiveRoute('idea') }}">
    <a href="{{ route('idea.index') }} " class="{{ setActiveRouteActivePage('idea') }}" rel="canonical"
        title="Ideas">
        <i class="material-icons {{ setActiveRouteActiveIcon('idea') }}">lightbulb</i>Ideas
    </a>
</li>
<li class="no-padding {{ setActiveRoute('proyecto') }}">
    <a href="{{ route('proyecto') }}" class="waves-effect waves-grey {{ setActiveRouteActivePage('proyecto') }}"
        rel="canonical" title="Proyectos de Base Tecnológica">
        <i class="material-icons {{ setActiveRouteActiveIcon('proyecto') }}">library_books</i>Proyectos
    </a>
</li>
<li class="no-padding {{ setActiveRoute('indicadores') }}">
    <a href="{{ route('indicadores') }}" class="{{ setActiveRouteActivePage('indicadores') }}">
        <i class="material-icons {{ setActiveRouteActiveIcon('indicadores') }}">info_outline</i>Indicadores
    </a>
</li>
<li class="no-padding {{ setActiveRoute('charla') }}">
    <a href="{{ route('charla') }}" class="{{ setActiveRouteActivePage('charla') }}" rel="canonical"
        title="Charlas Informativas">
        <i class="material-icons {{ setActiveRouteActiveIcon('charla') }}">record_voice_over</i>Charlas Informativas
    </a>
</li>
<li class="no-padding {{ setActiveRoute('taller') }}">
    <a href="{{ route('taller') }}" class="{{ setActiveRouteActivePage('taller') }}" rel="canonical"
        title="Taller de Fortalecimiento">
        <i class="material-icons {{ setActiveRouteActiveIcon('taller') }}">library_books</i>Taller de Fortalecimiento
    </a>
</li>
@can('index', App\User::class)
    <li class="no-padding {{ setActiveRoute('usuario') }}">
        <a class="waves-effect waves-grey {{ setActiveRouteActivePage('usuario') }}" href="{{ route('usuario.index') }}"
            rel="canonical" title="Usuarios">
            <i class="material-icons {{ setActiveRouteActiveIcon('usuario') }}">supervised_user_circle</i>Usuarios
        </a>
    </li>
@endcan
<li class="no-padding {{ setActiveRoute('empresa') }}">
    <a class="waves-effect waves-grey {{ setActiveRouteActivePage('empresa') }}" href="{{ route('empresa') }}"
        rel="canonical" title="Empresas">
        <i class="material-icons {{ setActiveRouteActiveIcon('empresa') }}">business_center</i>Empresas
    </a>
</li>
<li class="no-padding {{ setActiveRoute('nodo') }}">
    <a class="waves-effect waves-grey {{ setActiveRouteActivePage('nodo') }}" href="{{ route('nodo.index') }}"
        rel="canonical" title="Nodo">
        <i class="material-icons {{ setActiveRouteActiveIcon('nodo') }}">location_city</i>Nodo
    </a>
</li>
