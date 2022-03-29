@if ($proyecto->present()->proyectoFase() != App\Models\Proyecto::IsFinalizado() && $proyecto->present()->proyectoFase() != App\Models\Proyecto::IsSuspendido())
<div class="collection with-header col s12 m4 l4">
    <h5 href="!#" class="collection-header">Opciones</h5>
    @include('proyectos.options_ever')
    @if (Route::currentRouteName() == 'proyecto.inicio')
        @include('proyectos.options_inicio')
    @endif
    @if (Route::currentRouteName() == 'proyecto.planeacion')
        @include('proyectos.options_planeacion')
    @endif
    @if (Route::currentRouteName() == 'proyecto.ejecucion')
        @include('proyectos.options_ejecucion')
    @endif
    @if (Route::currentRouteName() == 'proyecto.cierre')
        @include('proyectos.options_cierre')
    @endif
</div>
@endif