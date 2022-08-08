<div class="collection with-header col s12 m4 l4">
    <h5 href="!#" class="collection-header">Opciones</h5>
    @if (Route::currentRouteName() != 'proyecto.suspender')
        <a href="{{route('proyecto.suspender', $proyecto->id)}}" class="collection-item">
            <i class="material-icons left">priority_high</i>
            Suspender proyecto.
        </a>
        @can('showOptionsForExperto', App\Models\Proyecto::class)
            @include('proyectos.options.options_ever_experto')
        @endcan
        @can('showOptionsForDinamizador', App\Models\Proyecto::class)
            @include('proyectos.options.options_ever_dinamizador')
        @endcan
    @endif
    @can('showOptionsForExperto', App\Models\Proyecto::class)
        @if (Route::currentRouteName() == 'proyecto.inicio' || Route::currentRouteName() == 'proyecto.detalle')
            @include('proyectos.options.options_inicio')
        @endif
        @if (Route::currentRouteName() == 'proyecto.planeacion' || Route::currentRouteName() == 'proyecto.detalle')
            @include('proyectos.options.options_planeacion')
        @endif
        @if (Route::currentRouteName() == 'proyecto.ejecucion' || Route::currentRouteName() == 'proyecto.detalle')
            @include('proyectos.options.options_ejecucion')
        @endif
        @if (Route::currentRouteName() == 'proyecto.cierre' || Route::currentRouteName() == 'proyecto.detalle')
            @include('proyectos.options.options_cierre')
        @endif
        @if (Route::currentRouteName() == 'proyecto.suspender' || Route::currentRouteName() == 'proyecto.detalle')
            @include('proyectos.options.options_suspender')
        @endif
    @endcan
</div>