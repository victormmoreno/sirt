<div class="section-project">
    <div class="row search-tabs-row search-tabs-header">
        <h5><b>Seleccione el Proyecto</b></h5>
        <div class="input-field col s12 m12 l4">
            <input type="text" id="filter_code" name="filter_code" class="autocomplete">
            <label for="filter_code">Código proyecto</label>
        </div>
        <div class="input-field col s12 m12 l8 right">
            <a class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_project_advanced"><i class="material-icons">list</i>Busqueda Avanzada</a>
            <a class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_code_project"><i class="material-icons">search</i>Buscar</a>
        </div>
    </div>
    <div>
        <div class="row search-tabs-row search-tabs-container grey lighten-4">
            <div class="col s12 m6 l6">
                <div class="mailbox-options grey lighten-4">
                    <ul class="grey lighten-4">
                        <li class="text-mailbox">Proyectos en fases de Ejecución, Cierre y finalizados</li>
                    </ul>
                </div>
            </div>
            <div class="col s12 m6 l6 right-align search-stats">
                <span class="m-r-sm">Resultados</span><span class="secondary-stats"></span>
            </div>
        </div>
    </div>
    <div class="row search-tabs-row search-tabs-container white lighten-4 result-projects container-error">
        @if(isset($accompaniment))
            <div class="col s12 m12 l12">
                <div class="card card-transparent p f-12">
                    <div class="card-content">
                        <span class="card-title p f-12">{{isset($accompaniment) ? $accompaniment->present()->accompanimentables() : 'Aún no has asociado el proyecto'}}</span>
                        <div class="position-top-right p f-12 mail-date hide-on-med-and-down"> Fecha cierre: {{$accompaniment->present()->accompanimentableEndDate()}}</div>
                        <p>{{$accompaniment->present()->accompanimentableObjetive()}}</p>
                        <input type="hidden" id="projects" name="projects" value="{{ old('projects', isset($accompaniment) ? $accompaniment->present()->accompanimentableId(): '') }}"/>
                    </div>
                    <div class="card-action">
                        <a class="orange-text text-darken-1" target="_blank" href="">Ver más</a>
                    </div>
                </div>
            </div>
        @else
            <div class="col s12 m12 l12">
                <div class="card card-transparent p f-12 m-t-lg">
                    <div class="card-content">
                        <span class="card-title p-h-lg  p f-12">Aún no has asociado el proyecto</span>
                        <input type="hidden" name="projects" id="projects"/>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
