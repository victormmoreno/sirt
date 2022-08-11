<h3>Contacto</h3>
<section>
    <div class="wizard-content">
        <div class="section-articulation search-tabs-row search-tabs-header">
            <div class="row">
                <div class="row">
                    <div class="input-field col s12 m12 l6">
                        <label class="active" for="scope_articulation">Alcance de la articulación<span class="red-text">*</span></label>
                        <select @if( isset($articulacion) && !$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif required  id="scope_articulation" name="scope_articulation" style="width: 100%" tabindex="-1">
                            <option value>Seleccione Alcance Articulación</option>
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
                    <div class="input-field col s12 m12 l6">
                        @if(isset($articulacion))
                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="name_entity" type="text" name="name_entity" class="validate" value="{{$articulacion->present()->articulacionPbtEntidad()}}">
                        @else
                            <input id="name_entity" type="text" name="name_entity" class="validate">
                        @endif
                        <label for="name_entity">Entidad con la que se realiza la articulación<span class="red-text">*</span></label>
                        <small id="name_entity-error" class="error red-text"></small>
                    </div>
                </div>
                <div class="row">

                    <div class="input-field col s12 m12 l6">
                        @if(isset($articulacion))
                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="name_contact" type="text" name="name_contact" class="validate" value="{{$articulacion->present()->articulacionPbtNombreContacto()}}">
                        @else
                            <input id="name_contact" type="text" name="name_contact" class="validate">
                        @endif
                        <label for="name_contact">Nombre de contacto<span class="red-text">*</span></label>
                        <small id="name_contact-error" class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m12 l6">
                        @if(isset($articulacion))
                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="email" name="email" type="email" value="{{$articulacion->present()->articulacionPbtEmail()}}">
                        @else
                            <input id="email" name="email" type="email">
                        @endif
                        <label for="email">Correo institucional de la entidad<span class="red-text">*</span></label>
                        <small id="email-error" class="error red-text"></small>
                    </div>
                </div>
                <div class="row">

                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l6">
                        @if(isset($articulacion))
                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="call_name" name="call_name" type="text" class="validate" value="{{$articulacion->present()->articulacionPbtNombreConvocatoria()}}">
                        @else
                            <input id="call_name" name="call_name" type="text" >
                        @endif
                        <label for="call_name">Nombre de convocatoria (Opcional)</label>
                        <small id="call_name-error" class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m12 l6">
                        @if(isset($articulacion))
                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="expected_date" name="expected_date" type="text" class="datepicker_articulation_date" value="{{$articulacion->present()->articulacionPbtFechaFinalizacion()}}">
                        @else
                            <input id="expected_date" name="expected_date" type="text" class="datepicker_articulation_date">
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
