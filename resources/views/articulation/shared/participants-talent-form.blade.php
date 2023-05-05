<div class="section-talent">
    <div class="row search-tabs-row search-tabs-header">
        <h5><b>Seleccione los talentos participantes</b></h5>
        <div class="input-field col s12 m12 l4">
            <input type="number" id="txtsearch_user" name="txtsearch_user" class="autocomplete">
            <label for="txtsearch_user">Número de documento</label>
        </div>
        <div class="col s12 m12 l8 right">
            <a class="waves-effect waves-grey bg-secondary white-text btn-flat search-tabs-button right" id="advanced_talent_filter"><i
                    class="material-icons">list</i>Busqueda Avanzada</a>
            <a class="waves-effect waves-grey btn-flat search-tabs-button right" id="search_talents"><i
                    class="material-icons">search</i>Buscar</a>
        </div>
    </div>
    <div class="row search-tabs-row search-tabs-container grey lighten-4">
        <div class="col s12 m6 l6"></div>
        <div class="col s12 m6 l6 right-align search-stats">
            <span class="m-r-sm">Resultados</span><span class="secondary-stats"></span>
        </div>
    </div>
    <div class="row search-tabs-row search-tabs-container white lighten-2 result-talents">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card card-transparent">
                    <div class="card-content">
                        <div class="search-result">
                            <p class="search-result-description">No se encontraron resultados</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row search-tabs-row search-tabs-container grey lighten-4">
        <div class="col s12 m12 l12">
            <div class="mailbox-options grey lighten-4 text-white">
                <ul class="grey lighten-4 text-white">
                    <li class="text-mailbox ">Talentos que participarán de la articulación</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row search-tabs-row search-tabs-container white lighten-4 alert-response-talents container-error">
        @if(isset($articulation))
            @foreach ($articulation->users as $user)
                <div class="row card-talent{{$user->id}}">
                    <div class="col s12 m12 l12">
                        <div class="card bs-dark ">
                            <div class="card-content ">
                                <span
                                    class="card-title p-h-lg  p f-12"> {{$user->present()->userDocumento()}} - {{$user->present()->userFullName()}}</span>
                                <input type="hidden" name="talents[]" value="{{$user->id}}"/>
                                <div class="position-top-right p f-12 mail-date hide-on-med-and-down no-m-b"> {!!$user->present()->userAcceso()!!}</div>

                            </div>
                            <div class="card-action">
                                <a target="_blank" class="waves-effect waves-red btn-flat m-b-xs primary-text"
                                    href="{{route('usuarios.show',$user->documento)}}"><i
                                        class="material-icons left"> link</i>Ver más</a>
                                <a onclick="filter_articulations.deleteTalent({{$user->id}});"
                                    class="waves-effect waves-red btn-flat m-b-xs danger-text"><i
                                        class="material-icons left"> delete_sweep</i>Eliminar</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col s12 m12 l12">
                <div class="card card-transparent p f-12 m-t-lg alert-empty-talents">
                    <div class="card-content">
                        <span class="card-title p-h-lg  p f-12">Aún no se han agregado talentos</span>
                        <input type="hidden" name="talents" id="talents"/>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
