<h3>Información Básica</h3>
<section>
    <div class="wizard-content">
        <div class="row search-tabs-row search-tabs-header">
            <div class="col m12">
                <h5><b>Ingresa la Información requerida</b></h5>
                <div class="row">
                    <div class="input-field col m12 s12">
                        <label for="name_accompaniment">Nombre</label>
                        <input id="name_accompaniment" name="name_accompaniment" type="text">
                    </div>
                    <div class="input-field col m12 s12">
                        <label for="description_accompaniment">Descripción (Opcional)</label>
                        <textarea id="description_accompaniment" name="description_accompaniment" type="text" class="materialize-textarea"></textarea>
                    </div>
                    <div class="input-field col m12 s12">
                        <label for="scope_accompaniment">Alcance</label>
                        <textarea id="scope_accompaniment" name="scope_accompaniment" type="text" class="materialize-textarea"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-project" style="display: none;">
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
            <div class="row search-tabs-row search-tabs-container white lighten-4 alert-response">
                <div class="row container-error">
                @if(isset($accompaniment))
                        <div class="col s12 m12 l12">
                            <div class="card card-transparent p f-12">
                                <div class="card-content">
                                    <span class="card-title p f-12">{{$accom->present()->articulacionPbtCodeProyecto()}} - {{$articulacion->present()->articulacionPbtNameProyecto()}}</span>
                                    <div class="position-top-right p f-12 mail-date hide-on-med-and-down"> Fecha cierre: {{$articulacion->present()->articulacionPbtClosingDateProyecto()}}</div>
                                    <p>{{$articulacion->present()->articulacionPbtObjetivoProyecto()}}</p>
                                    <input type="hidden" id="proyect" name="proyect" value="{{$articulacion->present()->articulacionPbtIdProyecto()}}"/>
                                </div>
                                <div class="card-action">
                                <a class="orange-text text-darken-1" target="_blank" href="{{route('proyecto.detalle', $articulacion->present()->articulacionPbtIdProyecto())}}">Ver más</a>
                                </div>
                            </div>
                        </div>


                @else

                        <div class="col s12 m12 l12">
                            <div class="card card-transparent p f-12 m-t-lg">
                                <div class="card-content">
                                    <div class="search-result">
                                        <p class="search-result-description">Aún no has asociado el proyecto</p>
                                    </div>
                                </div>
                            </div>
                            <div class="input-field col m12 s12">
                                <input type="hidden" name="projects" id="projects" style="display:none"/>
                            </div>
                        </div>

                @endif
                </div>
            </div>
        </div>
        <div class="section-company" style="display: none;">
            <div class="row search-tabs-row search-tabs-header">
                <h5><b>Seleccione la sede de la empresa</b></h5>
                <div class="input-field col s12 m12 l4">
                    <input type="text" id="filter_nit" name="filter_nit" class="autocomplete">
                    <label for="filter_nit">Nit Empresa</label>
                </div>
                <div class="input-field col s12 m12 l8 right">
                    <a class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_company_advanced"><i class="material-icons">list</i>Busqueda Avanzada</a>
                    <a class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_nit_company"><i class="material-icons">search</i>Buscar</a>
                </div>
            </div>
            <div class="row search-tabs-row search-tabs-container grey lighten-4">
                <div class="col s12 m6 l6">
                    <div class="mailbox-options grey lighten-4">
                        <ul class="grey lighten-4">
                            <li class="text-mailbox">Sedes de la empresa</li>
                        </ul>
                    </div>
                </div>
                <div class="col s12 m6 l6 right-align search-stats">
                    <span class="m-r-sm">Resultados</span><span class="secondary-stats"></span>
                </div>
            </div>
            <div class="row search-tabs-row search-tabs-container white lighten-4 alert-response-sedes">
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
                        <ul class="grey lighten-4 text-white result-sede">
                            <li class="text-mailbox ">Sede que participará en la articulación</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row search-tabs-row search-tabs-container white lighten-4 alert-response-company">
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card transparent bs-dark">
                            <div class="card-content">
                                <span class="card-title p-h-lg">Colanta - Medellín Antioquia</span>
                                <input type="hidden" name="txtsede" value=""/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-talent" style="display: none;">
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
            <div class="row search-tabs-row search-tabs-container white lighten-4 alert-response-talents">
                @if(isset($articulacion))
                    @foreach ($articulacion->talentos as $talento)
                        <div class="row card-talent{{$talento->user->id}}">
                            <div class="col s12 m12 l12">
                                <div class="card bs-dark ">
                                    <div class="card-content ">

                                        <span class="card-title p-h-lg  p f-12"> {{$talento->user->present()->userDocumento()}} - {{$talento->user->present()->userFullName()}}</span>
                                        <input type="hidden" name="talentos[]" value="{{$talento->id}}"/>
                                        <div class="p-h-lg">
                                            <input  type="radio" @if($talento->pivot->talento_lider == 1) checked @endif @if(isset($articulacion) && !$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif class="with-gap" name="txttalento_interlocutor" id="radioInterlocutor{{$talento->id}}" value="{{$talento->id}}" />
                                            <label for ="radioInterlocutor{{$talento->id}}">Talento Interlocutor</label>
                                        </div>
                                        <div class="position-top-right p f-12 mail-date hide-on-med-and-down no-m-b">  Acceso al sistema: {{$talento->user->present()->userAcceso()}}</div>

                                        <p class="hide-on-med-and-down no-m-b"> Miembro desde {{$talento->user->present()->userCreatedAtFormat()}}</p>
                                    </div>
                                    <div class="card-action">
                                        <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="{{route('usuario.usuarios.show',$talento->user->documento)}}"><i class="material-icons left"> link</i>Ver más</a>
                                        @if(isset($articulacion) && $articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio()))
                                        <a onclick="filter_project.deleteTalent({{$talento->user->id}});" class="waves-effect waves-red btn-flat m-b-xs red-text"><i class="material-icons left"> delete_sweep</i>Eliminar</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                @else
                <div class="row talent-empty">
                    <div class="col s12 m12 l12">
                        <div class="card card-transparent p f-12 m-t-lg">
                            <div class="card-content">
                                <div class="search-result">
                                    <p class="search-result-description">Aún no se han agregado talentos</p>
                                </div>
                            </div>
                        </div>
                        <div class="input-field col m12 s12">
                            <input type="hidden" name="talent" id="talent" style="display:none"/>
                        </div>
                    </div>
                </div>
                @endif

            </div>

        </div>
    </div>
</section>
