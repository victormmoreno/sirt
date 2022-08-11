<div class="section-talent">
    <div class="row search-tabs-row search-tabs-header">
        <h5><b>Seleccione el talento Interlocutor</b></h5>
        <div class="input-field col s12 m12 l4">
        <input type="number" id="txtsearch_user" name="txtsearch_user" class="autocomplete">
        <label for="txtsearch_user">Número de documento</label>
        </div>
        <div class="col s12 m12 l8 right">
            <a class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_talents_advanced"><i class="material-icons">list</i>Busqueda Avanzada</a>
            <a class="waves-effect waves-grey btn-flat search-tabs-button right" id="search_talent"><i class="material-icons">search</i>Buscar</a>
        </div>
    </div>
    <div class="row search-tabs-row search-tabs-container grey lighten-4">
        <div class="col s12 m6 l6"></div>
        <div class="col s12 m6 l6 right-align search-stats">
            <span class="m-r-sm">Resultados</span><span class="secondary-stats"></span>
        </div>
    </div>
    <div class="row search-tabs-row search-tabs-container white lighten-4 result-talents container-error">
    @if(isset($accompaniment->interlocutor))
        <div class="col s12 m12 l12">
            <div class="card card-transparent p f-12 m-t-lg">
                <div class="card-content">
                    <span class="card-title p f-12">{{$accompaniment->present()->accompanimentInterlocutorTalent()}}</span>
                    <div class="input-field col m12 s12">
                        <input type="hidden" name="talent" id="talent" value="{{$accompaniment->interlocutor->id}}"/>
                    </div>
                    <div class="position-top-right p f-12 mail-date hide-on-med-and-down">  Acceso al sistema: {{$accompaniment->interlocutor->present()->userAcceso()}}</div>
                    <p class="hide-on-med-and-down"> Miembro desde {{$accompaniment->interlocutor->present()->userCreatedAtFormat()}}</p>
                </div>
                <div class="card-action">
                    <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="{{route('usuario.usuarios.show',$accompaniment->interlocutor->documento)}}"><i class="material-icons left">link</i>Ver más</a>
                </div>
            </div>
        </div>
    @else
        <div class="col s12 m12 l12">
            <div class="card card-transparent p f-12 m-t-lg">
                <div class="card-content">
                    <span class="card-title p-h-lg  p f-12">Aún no se han agregado talentos</span>
                    <input type="hidden" name="talent" id="talent"/>
                </div>
            </div>
        </div>
    @endif
    </div>
</div>
