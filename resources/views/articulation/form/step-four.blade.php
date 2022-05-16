<h3>Articulaciones</h3>
<section>
    <div class="wizard-content">
        <div class="row search-tabs-row search-tabs-header">
            <div class="col m12">
                <h5><b>¿Desea registrar una articulación?</b></h5>
                <div class="row">
                    <div class="col s12 m12 l12">
                        <p class="p-v-xs text-center">
                            <label align="justify" class="black-text text-black">
                                ¿Desea registrar una articulación?
                            </label>
                            <input class="articulation" id="articulation_no" name="articulation" type="radio" value="no" checked />
                            <label align="justify" for="articulation_no" class="black-text text-black">
                                No
                            </label>
                            <input  class="articulation" id="articulation_yes" name="articulation" type="radio" value="si"/>
                            <label align="justify" for="articulation_yes" class="black-text text-black">
                                Si
                            </label>

                        </p>
                        <small id="articulation-error" class="error red-text"></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-articulation search-tabs-row search-tabs-header" style="display: none;">
            <div class="col m12">
                <div class="row">
                    <div class="radio-buttons">
                        <h5>Tipo Articulación</h5>
                        <label class="custom-radio">
                        <input type="radio" name="articulation_type" value="pi" checked />
                        <span class="radio-btn">
                            <h3>P.I</h3>
                        </span>
                        </label>
                        <label class="custom-radio">
                        <input type="radio" name="articulation_type" value="ce"/>
                        <span class="radio-btn">
                            <h3>Creación empresas</h3>
                        </span>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="articulation_type" value="con"/>
                            <span class="radio-btn">
                                <h3>convocatoria</h3>
                            </span>
                        </label>
                    </div>
                    <div class="input-field col m12 s12">
                        <label for="name_articulation">Nombre Articulación</label>
                        <input id="name_articulation" name="name_articulation" type="text">
                    </div>
                    <div class="input-field col m12 s12">
                        <label for="description_articulation">Descripción Articulación (Opcional)</label>
                        <textarea id="description_articulation" name="description_articulation" type="text" class="materialize-textarea validate"></textarea>
                    </div>
                    <div class="input-field col m12 s12">
                        <label for="scope_articulation">Alcance Artuculación</label>
                        <textarea id="scope_articulation" name="scope_articulation" type="text" class="materialize-textarea"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l6">
                        @if(isset($articulacion))
                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="start_date" name="start_date" type="text" class="datepicker_accompaniable_max_dat" value="{{$articulacion->present()->articulacionPbtFechaFinalizacion()}}">
                        @else
                            <input id="start_date" name="start_date" type="text" class="datepicker_accompaniable_max_date">
                        @endif

                        <label for="start_date">Fecha de inicio articulación<span class="red-text">*</span></label>
                        <small id="start_date-error" class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m12 l6">
                        <label class="active" for="scope_articulacion">Alcance<span class="red-text">*</span></label>
                        <select @if( isset($articulacion) && !$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="scope_articulacion" name="scope_articulacion" style="width: 100%" tabindex="-1">
                            <option value="">Seleccione Alcance Articulación</option>
                                @forelse($scopes  as $id => $name)
                                    @if (isset($articulacion))
                                        <option value="{{$id}}" {{ old('scope_articulacion', $articulacion->alcancearticulacion->id) == $id ? 'selected':'' }}>{{$name}}</option>
                                    @else
                                        <option value="{{$id}}" {{ old('scope_articulacion') == $id ? 'selected':'' }}>{{$name}}</option>
                                    @endif
                                @empty
                                    <option>No se encontraron resultados</option>
                                @endforelse
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l6">
                        @if(isset($articulacion))
                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="name_entity" type="text" name="name_entity" class="validate" value="{{$articulacion->present()->articulacionPbtEntidad()}}">
                        @else
                            <input id="name_entity" type="text" name="name_entity" class="validate">
                        @endif
                        <label for="name_entity">Entidad con la que se realiza la articulación<span class="red-text">*</span></label>
                        <small id="name_entity-error" class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m12 l6">
                        @if(isset($articulacion))
                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="name_contact" type="text" name="name_contact" class="validate" value="{{$articulacion->present()->articulacionPbtNombreContacto()}}">
                        @else
                            <input id="name_contact" type="text" name="name_contact" class="validate">
                        @endif
                        <label for="name_contact">Nombre de contacto<span class="red-text">*</span></label>
                        <small id="name_contact-error" class="error red-text"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l12">
                        @if(isset($articulacion))
                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="email" name="email" type="email" value="{{$articulacion->present()->articulacionPbtEmail()}}">
                        @else
                            <input id="email" name="email" type="email">
                        @endif
                        <label for="email">Correo institucional de la entity<span class="red-text">*</span></label>
                        <small id="email-error" class="error red-text"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l6">
                        @if(isset($articulacion))
                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="call_name" name="call_name" type="text" class="validate" value="{{$articulacion->present()->articulacionPbtNombreConvocatoria()}}">
                        @else
                            <input id="call_name" name="call_name" type="text" class="validate">
                        @endif
                        <label for="call_name">Nombre de convocatoria (Opcional)</label>
                        <small id="call_name-error" class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m12 l6">
                        @if(isset($articulacion))
                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="expected_date" name="expected_date" type="text" class="datepicker_accompaniable_date" value="{{$articulacion->present()->articulacionPbtFechaFinalizacion()}}">
                        @else
                            <input id="expected_date" name="expected_date" type="text" class="datepicker_accompaniable_date">
                        @endif

                        <label for="expected_date">Fecha esperada de finalización <span class="red-text">*</span></label>
                        <small id="expected_date-error" class="error red-text"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l12">
                        @if(isset($articulacion))
                            <textarea  @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  name="objective" class="materialize-textarea" length="500" maxlength="500" id="objective">{{$articulacion->present()->articulacionPbtObjetivo()}}</textarea>
                        @else
                            <textarea name="objective" class="materialize-textarea" length="3500" maxlength="3500" id="objective"></textarea>
                        @endif

                        <label for="objective">Objetivo<span class="red-text">*</span></label>
                        <small id="objective-error" class="error red-text"></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
