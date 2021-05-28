
<ul class="collapsible" data-collapsible="expandable">
    <li class="active">
        <div class="collapsible-header grey lighten-2 active"><i class="material-icons">subtitles</i>1. Seleccione PBT</div>
        <div class="collapsible-body" style="display: block;">
            
            @if ($btnText == 'Guardar')
                <div class="row search-tabs-row search-tabs-header">
                    <div class="input-field col s12 m12 l4">
                        <input type="text" id="filter_code" name="filter_code" class="autocomplete">
                        <label for="filter_code">Código proyecto</label>
                    </div>
                    <div class="input-field col s12 m12 l8 right">
                        <a class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_project_advanced"><i class="material-icons">list</i>Busqueda Avanzada</a>
                        <a class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_code_project"><i class="material-icons">search</i>Buscar</a>
                    </div>
                </div>
            @endif
            <div class="row search-tabs-row search-tabs-container grey lighten-4">
                <div class="col s12 m6 l6">
                    <div class="mailbox-options grey lighten-4">
                        <ul class="grey lighten-4">
                            <li class="text-mailbox">Proyectos finalizados</li>                                            
                        </ul>
                    </div>
                </div>
                <div class="col s12 m6 l6 right-align search-stats">
                    <span class="m-r-sm">Resultados</span><span class="secondary-stats"></span>
                </div>
            </div>
            <div class="row search-tabs-row search-tabs-container white lighten-4 alert-response">
                @if(isset($actividad))
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="card card-transparent p f-12">
                                
                                <div class="card-content">
                                    <span class="card-title p f-12">{{$actividad->articulacionpbt->present()->articulacionPbtCodeProyecto()}} - {{$actividad->articulacionpbt->present()->articulacionPbtNameProyecto()}}</span>
                                    <div class="position-top-right p f-12 mail-date hide-on-med-and-down"> Fecha cierre: {{$actividad->articulacionpbt->present()->articulacionPbtClosingDateProyecto()}}</div>
                                    <p>{{$actividad->articulacionpbt->present()->articulacionPbtObjetivoProyecto()}}</p>
                                    <input type="hidden" name="txtpbt" value="{{$actividad->articulacionpbt->present()->articulacionPbtIdProyecto()}}"/>
                                </div>
                                <div class="card-action">
                                <a class="orange-text text-darken-1" target="_blank" href="{{route('proyecto.detalle', $actividad->articulacionpbt->present()->articulacionPbtIdProyecto())}}">Ver más</a>
                                </div>
                            </div>
                        </div>
                    </div>

                @else
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div class="card card-transparent">
                                <div class="card-content">
                                    <div class="search-result">
                                        <p class="search-result-description">No se encontraron resultados</p>
                                    </div>
                                </div>
                            </div>
                            <small id="txtpbt-error" class="error red-text"></small>
                        </div>
                    </div>
                @endif 
                
            </div>
        </div>
    </li>
    <li>
        <div class="collapsible-header grey lighten-2"><span class="text-white"><i class="material-icons text-white">supervisor_account</i>2. Miembros (Talentos)</span></div>
        <div class="collapsible-body" style="">
            @if ($btnText == 'Guardar')
                <div class="row search-tabs-row search-tabs-header">
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
            @else
                @if(isset($actividad) && $actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio()))
                    <div class="row search-tabs-row search-tabs-header">
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
                @endif
            @endif
            <div class="row search-tabs-row search-tabs-container grey lighten-4">
                <div class="col s12 m12 l12">
                    <div class="mailbox-options grey lighten-4 text-white">
                        <ul class="grey lighten-4 text-white">
                            <li class="text-mailbox ">Talentos que participarán de la articulación</li>                                            
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row search-tabs-row search-tabs-container white lighten-4 alert-response-talents">
                @if(isset($actividad))
                    @foreach ($actividad->articulacionpbt->talentos as $talento)
                        <div class="row card-talent{{$talento->user->id}}">
                            <div class="col s12 m12 l12">
                                <div class="card bs-dark ">
                                    <div class="card-content ">
                                        
                                        <span class="card-title p-h-lg  p f-12"> {{$talento->user->present()->userDocumento()}} - {{$talento->user->present()->userFullName()}}</span>
                                        <input type="hidden" name="talentos[]" value="{{$talento->id}}"/>
                                        <div class="p-h-lg">
                                            <input  type="radio" @if($talento->pivot->talento_lider == 1) checked @endif @if(isset($actividad) && !$actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif class="with-gap" name="txttalento_interlocutor" id="radioInterlocutor{{$talento->id}}" value="{{$talento->id}}" />
                                            <label for ="radioInterlocutor{{$talento->id}}">Talento Interlocutor</label>
                                        </div>
                                        <div class="position-top-right p f-12 mail-date hide-on-med-and-down no-m-b">  Acceso al sistema: {{$talento->user->present()->userAcceso()}}</div>
                                        
                                        <p class="hide-on-med-and-down no-m-b"> Miembro desde {{$talento->user->present()->userCreatedAtFormat()}}</p>
                                    </div>
                                    <div class="card-action">
                                        <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="{{route('usuario.usuarios.show',$talento->user->documento)}}"><i class="material-icons left"> link</i>Ver más</a>
                                        @if(isset($actividad) && $actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio()))
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
                        <div class="card card-transparent">
                            <div class="card-content">
                                <div class="search-result">
                                    <p class="search-result-description">Aún no se han agregado talentos</p>
                                </div>
                            </div>
                        </div>
                        <small id="talentos-error" class="error red-text"></small>
                    </div>
                </div>
                @endif

            </div> 
        </div>
    </li>
    <li>
        <div class="collapsible-header grey lighten-2"><i class="material-icons">library_books</i>3. Información básica</div>
        <div class="collapsible-body" style="">
            <div class="row search-tabs-row search-tabs-header">
                <div class="card card-transparent">
                    <div class="card-content"> 
                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                @if(isset($actividad))
                                    <input @if(!$actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txtnombre_articulacion" name="txtnombre_articulacion" type="text" class="validate" value="{{$actividad->articulacionpbt->present()->articulacionPbtName()}}">
                                @else
                                    <input  id="txtnombre_articulacion" name="txtnombre_articulacion" type="text" class="validate">
                                @endif
                                <label for="txtnombre_articulacion">Nombre Articulación <span class="red-text">*</span></label>
                                <small id="txtnombre_articulacion-error" class="error red-text"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12 l6">
                                <label class="active" for="txt_tipo_articulacion">Tipo Articulación<span class="red-text">*</span></label>
                                <select  @if(isset($actividad) && !$actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  name="txt_tipo_articulacion" id="txt_tipo_articulacion">
                                    <option value="">Seleccione tipo Articulación</option>
                                    @forelse($tipoarticulaciones  as $id => $name)
                                    @if (isset($actividad))
                                        <option value="{{$id}}" {{ old('txt_tipo_articulacion', $actividad->articulacionpbt->tipoarticulacion->id) == $id ? 'selected':'' }}>{{$name}}</option> 
                                    @else
                                        <option value="{{$id}}" {{ old('txt_tipo_articulacion') == $id ? 'selected':'' }}>{{$name}}</option>
                                    @endif
                                    @empty
                                        <option>No se encontraron resultados</option>
                                    @endforelse
                                </select>
                                <small id="txt_tipo_articulacion-error" class="error red-text"></small>
                            </div>
                            <div class="input-field col s12 m12 l6">
                                <label class="active" for="txt_alcance_articulacion">Alcance<span class="red-text">*</span></label>
                                <select @if( isset($actividad) && !$actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txt_alcance_articulacion" name="txt_alcance_articulacion" style="width: 100%" tabindex="-1">
                                    <option value="">Seleccione Alcance Articulación</option>
                                    @forelse($alcances  as $id => $name)
                                        @if (isset($actividad))
                                            <option value="{{$id}}" {{ old('txt_alcance_articulacion', $actividad->articulacionpbt->alcancearticulacion->id) == $id ? 'selected':'' }}>{{$name}}</option> 
                                        @else
                                            <option value="{{$id}}" {{ old('txt_alcance_articulacion') == $id ? 'selected':'' }}>{{$name}}</option>
                                        @endif
                                    @empty
                                        <option>No se encontraron resultados</option>
                                    @endforelse
                                </select>
                                <small id="txt_alcance_articulacion-error" class="error red-text"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12 l6">
                                @if(isset($actividad))
                                    <input @if(!$actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txtname_entidad" type="text" name="txtname_entidad" class="validate" value="{{$actividad->articulacionpbt->present()->articulacionPbtEntidad()}}">
                                @else
                                    <input id="txtname_entidad" type="text" name="txtname_entidad" class="validate">
                                @endif
                                <label for="txtname_entidad">Entidad con la que se realiza la articulación<span class="red-text">*</span></label>
                                <small id="txtname_entidad-error" class="error red-text"></small>
                            </div>
                            <div class="input-field col s12 m12 l6">
                                @if(isset($actividad))
                                    <input @if(!$actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txtname_contact" type="text" name="txtname_contact" class="validate" value="{{$actividad->articulacionpbt->present()->articulacionPbtNombreContacto()}}">
                                @else
                                    <input id="txtname_contact" type="text" name="txtname_contact" class="validate">
                                @endif
                                <label for="txtname_contact">Nombre de contacto<span class="red-text">*</span></label>
                                <small id="txtname_contact-error" class="error red-text"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                @if(isset($actividad))
                                    <input @if(!$actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txtemail" name="txtemail" type="email" class="validate" value="{{$actividad->articulacionpbt->present()->articulacionPbtEmail()}}">
                                @else
                                    <input id="txtemail" name="txtemail" type="email" class="validate">
                                @endif
                                <label for="txtemail">Correo institucional de la entidad<span class="red-text">*</span></label>
                                <small id="txtemail-error" class="error red-text"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12 l6">
                                @if(isset($actividad))
                                    <input @if(!$actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txtnombre_convocatoria" name="txtnombre_convocatoria" type="text" class="validate" value="{{$actividad->articulacionpbt->present()->articulacionPbtNombreConvocatoria()}}">
                                @else
                                    <input id="txtnombre_convocatoria" name="txtnombre_convocatoria" type="text" class="validate">
                                @endif
                                <label for="txtnombre_convocatoria">Nombre de convocatoria (Opcional)</label>
                                <small id="txtnombre_convocatoria-error" class="error red-text"></small>
                            </div>
                            <div class="input-field col s12 m12 l6">
                                @if(isset($actividad))
                                    <input @if(!$actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txtfecha_esperada" name="txtfecha_esperada" type="text" class="validate datepicker-min-date" value="{{$actividad->articulacionpbt->present()->articulacionPbtFechaFinalizacion()}}">
                                @else
                                    <input id="txtfecha_esperada" name="txtfecha_esperada" type="text" class="validate datepicker-min-date">
                                @endif
                                
                                <label for="txtfecha_esperada">Fecha esperada de finalización <span class="red-text">*</span></label>
                                <small id="txtfecha_esperada-error" class="error red-text"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                @if(isset($actividad))
                                    <textarea  @if(!$actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  name="txtobjetivo" class="materialize-textarea" length="500" maxlength="500" id="txtobjetivo">{{$actividad->articulacionpbt->present()->articulacionPbtObjetivo()}}</textarea>
                                @else
                                    <textarea name="txtobjetivo" class="materialize-textarea" length="3500" maxlength="3500" id="txtobjetivo"></textarea>
                                @endif
                                
                                <label for="txtobjetivo">Objetivo<span class="red-text">*</span></label>
                                <small id="txtobjetivo-error" class="error red-text"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
</ul>
@if ($btnText == 'Guardar')
<center>
    <button type="submit" class="waves-effect cyan darken-1 btn center-aling">
        <i class="material-icons right">done</i>
        @if ($btnText == 'Modificar')
            {{$btnText}}
        @else
            {{$btnText}}
        @endif
    </button>   
    
    <a href="{{route('articulaciones.index')}}" class="waves-effect red lighten-2 btn center-aling">
        <i class="material-icons right">backspace</i>Cancelar
    </a>
</center>
@else
    @if(isset($actividad) && $actividad->articulacionpbt->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio()))
    <center>
        <button type="submit" class="waves-effect cyan darken-1 btn center-aling">
            <i class="material-icons right">done</i>
            @if ($btnText == 'Modificar')
                {{$btnText}}
            @else
                {{$btnText}}
            @endif
        </button>   
        
        <a href="{{route('articulaciones.show', $actividad->articulacionpbt->id)}}" class="waves-effect red lighten-2 btn center-aling">
            <i class="material-icons right">backspace</i>Cancelar
        </a>
    </center>
    @endif
@endif