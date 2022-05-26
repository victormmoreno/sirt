<h3>Tipo de articulación</h3>
<section>
    <div class="wizard-content">
        <div class="section-articulation search-tabs-row search-tabs-header">
            <div class="row">
                <div class="radio-buttons">
                    <h5>Seleccione un tipo de articulación</h5>
                    <label class="custom-radio">
                        <input type="radio" name="articulation_type" value="pi" checked />
                        <span class="radio-btn">
                            <h3>P.I</h3>
                        </span>
                    </label>
                    @if($accompaniment->present()->accompanimentableType() != "Sede")
                    <label class="custom-radio">
                        <input type="radio" name="articulation_type" value="ce"/>
                        <span class="radio-btn">
                            <h3>Creación empresas</h3>
                        </span>
                    </label>
                    @endif
                    <label class="custom-radio">
                        <input type="radio" name="articulation_type" value="con"/>
                        <span class="radio-btn">
                            <h3>convocatoria</h3>
                        </span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</section>
