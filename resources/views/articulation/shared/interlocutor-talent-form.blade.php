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
    <div class="row search-tabs-row search-tabs-container white lighten-4 result-talents container-error">
        @if(isset($articulacion))
            @foreach ($articulacion->talentos as $talento)
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
            @endforeach
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
