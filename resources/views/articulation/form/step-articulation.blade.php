<h3>Información básica</h3>
<section>
    <div class="wizard-content">
        <div class="section-articulation search-tabs-row search-tabs-header">
            <div class="col m12">
                <div class="row">
                    <div class="input-field col s12 m12 l12">
                        @if(isset($articulacion))
                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="start_date" name="start_date" type="text" class="datepicker_articulation_max_date" value="{{$articulacion->present()->articulacionPbtFechaFinalizacion()}}">
                        @else
                            <input id="start_date" name="start_date" type="text" class="datepicker_articulation_max_date">
                        @endif

                        <label for="start_date">Fecha de inicio articulación<span class="red-text">*</span></label>
                        <small id="start_date-error" class="error red-text"></small>
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
                        <label for="scope">Alcance<span class="red-text">*</span></label>
                        <textarea id="scope" name="scope" type="text" class="materialize-textarea"></textarea>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
