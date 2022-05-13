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
                            <input  class="articulation" id="articulation_yes" name="articulation" type="radio" value="si" onchange="articulacionCierre.checkedTypePostulacion()" />
                            <label align="justify" for="articulation_yes" class="black-text text-black">
                                Si
                            </label>
                            <input class="articulation" id="articulation_no" name="articulation" type="radio" value="no" checked onchange="articulacionCierre.checkedTypePostulacion()" />
                            <label align="justify" for="articulation_no" class="black-text text-black">
                                No
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
                        <input type="radio" name="radio" checked />
                        <span class="radio-btn">
                            <h3>P.I</h3>
                        </span>
                        </label>
                        <label class="custom-radio">
                        <input type="radio" name="radio" />
                        <span class="radio-btn">
                            <h3>Creación empresas</h3>
                        </span>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="radio" />
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
                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txtfecha_inicio" name="txtfecha_inicio" type="text" class="datepicker picker__input" value="{{$articulacion->present()->articulacionPbtstartDate()}}">
                        @else
                            <input id="txtfecha_inicio" name="txtfecha_inicio" type="text" class="datepicker picker__input">
                        @endif
                        <label for="txtfecha_inicio">Fecha de inicio de la articulación <span class="red-text">*</span></label>
                        <small id="txtfecha_inicio-error" class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m12 l6">
                        <label class="active" for="txt_alcance_articulacion">Alcance<span class="red-text">*</span></label>
                        <select @if( isset($articulacion) && !$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txt_alcance_articulacion" name="txt_alcance_articulacion" style="width: 100%" tabindex="-1">
                            <option value="">Seleccione Alcance Articulación</option>
                            <option value="">Local</option>
                            <option value="">Regional</option>
                            <option value="">Nacional</option>
                            <option value="">Internacional</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l6">
                        @if(isset($articulacion))
                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txtname_entidad" type="text" name="txtname_entidad" class="validate" value="{{$articulacion->present()->articulacionPbtEntidad()}}">
                        @else
                            <input id="txtname_entidad" type="text" name="txtname_entidad" class="validate">
                        @endif
                        <label for="txtname_entidad">Entidad con la que se realiza la articulación<span class="red-text">*</span></label>
                        <small id="txtname_entidad-error" class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m12 l6">
                        @if(isset($articulacion))
                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txtname_contact" type="text" name="txtname_contact" class="validate" value="{{$articulacion->present()->articulacionPbtNombreContacto()}}">
                        @else
                            <input id="txtname_contact" type="text" name="txtname_contact" class="validate">
                        @endif
                        <label for="txtname_contact">Nombre de contacto<span class="red-text">*</span></label>
                        <small id="txtname_contact-error" class="error red-text"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l12">
                        @if(isset($articulacion))
                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txtemail" name="txtemail" type="email" class="validate" value="{{$articulacion->present()->articulacionPbtEmail()}}">
                        @else
                            <input id="txtemail" name="txtemail" type="email" class="validate">
                        @endif
                        <label for="txtemail">Correo institucional de la entidad<span class="red-text">*</span></label>
                        <small id="txtemail-error" class="error red-text"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l6">
                        @if(isset($articulacion))
                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txtnombre_convocatoria" name="txtnombre_convocatoria" type="text" class="validate" value="{{$articulacion->present()->articulacionPbtNombreConvocatoria()}}">
                        @else
                            <input id="txtnombre_convocatoria" name="txtnombre_convocatoria" type="text" class="validate">
                        @endif
                        <label for="txtnombre_convocatoria">Nombre de convocatoria (Opcional)</label>
                        <small id="txtnombre_convocatoria-error" class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m12 l6">
                        @if(isset($articulacion))
                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txtfecha_esperada" name="txtfecha_esperada" type="text" class="validate datepicker-min-date" value="{{$articulacion->present()->articulacionPbtFechaFinalizacion()}}">
                        @else
                            <input id="txtfecha_esperada" name="txtfecha_esperada" type="text" class="validate datepicker-min-date">
                        @endif

                        <label for="txtfecha_esperada">Fecha esperada de finalización <span class="red-text">*</span></label>
                        <small id="txtfecha_esperada-error" class="error red-text"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l12">
                        @if(isset($articulacion))
                            <textarea  @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  name="txtobjetivo" class="materialize-textarea" length="500" maxlength="500" id="txtobjetivo">{{$articulacion->present()->articulacionPbtObjetivo()}}</textarea>
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
</section>
