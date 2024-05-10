@canany(['showOptionsForDinamizador', 'showOptionsForExperto'], App\Models\Proyecto::class)
    <div class="collection with-header col s12 m4 l4">
        <h5 href="!#" class="collection-header">Opciones</h5>
        @if (Route::currentRouteName() != 'proyecto.suspender')
            @canany(['showOptionsForDinamizador', 'showOptionsForExperto'], App\Models\Proyecto::class)
                <a href="{{route('proyecto.suspender', $proyecto->id)}}" class="collection-item">
                    <i class="material-icons left">priority_high</i>
                    Cancelar proyecto.
                </a>
            @endcan
            @can('showOptionsForExperto', App\Models\Proyecto::class)
                @include('proyectos.options.options_ever_experto')
            @endcan
            @can('showOptionsForDinamizador', App\Models\Proyecto::class)
                @include('proyectos.options.options_ever_dinamizador')
            @endcan
        @endif

        @can('showOptionsForExperto', App\Models\Proyecto::class)
            @if (Route::currentRouteName() == 'proyecto.inicio')
                @include('proyectos.options.options_inicio')
            @endif
            @if (Route::currentRouteName() == 'proyecto.planeacion')
                @include('proyectos.options.options_planeacion')
            @endif
            @if (Route::currentRouteName() == 'proyecto.ejecucion')
                @include('proyectos.options.options_ejecucion')
            @endif
            @if (Route::currentRouteName() == 'proyecto.cierre')
                @include('proyectos.options.options_cierre')
            @endif
            @if (Route::currentRouteName() == 'proyecto.suspender')
                @include('proyectos.options.options_suspender')
            @endif
            @if ($proyecto->fase->nombre == $proyecto->IsFinalizado())
                @include('proyectos.options.options_end')
            @endif
        @endcan
    </div>
@endcan
