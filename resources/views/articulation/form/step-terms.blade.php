<h3>Terminos &amp; Condiciones</h3>
<section>
    <div class="wizard-content">
        <div class="wizardTerms ">
            <div class="row search-tabs-row search-tabs-header">
                <div>
                    <ul class="collection with-header">
                        <li class="collection-header bg-primary-lighten black-text">El articulador se compromete a:</li>
                        <li class="collection-item">Acompañar a talento en la recolección de información y procesos pertinentes para cumplir los requisitos de la postulación según el acompañamiento a ejecutar.</li>
                        <li class="collection-item">Guardar confidencialidad y compromiso de la información susceptible del proyecto, la empresa y/o emprendimiento.</li>
                    </ul>
                </div>
                <div>
                    <ul class="collection with-header">
                        <li class="collection-header bg-primary-lighten black-text">El talento se compromete a:</li>
                        <li class="collection-item">Guardar confidencialidad y compromiso de la información susceptible del proyecto, la empresa y/o emprendimiento.</li>
                        <li class="collection-item">Brindar la información necesaria para realizar seguimiento acompañamiento de la articulación y/o articulaciones.</li>
                        <li class="collection-item">Estar atento a las fechas de la postulación, convenio o participación.</li>
                        <li class="collection-item">Facilitar la información al Articulador para cargar en plataforma los documentos donde se evidencie la participación y realizar aprobación de fases en los momentos que se requieran.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="search-tabs-row search-tabs-header">
            <div class="input-field col m12 s12">
                <label for="expected_results">{{ __('Expected Results') }} <span class="red-text">*</span></label>
                <textarea id="expected_results" name="expected_results" type="text" class="materialize-textarea">{{ old('expected_results', isset($articulationStage->expected_results) ? $articulationStage->expected_results: '') }}</textarea>
            </div>
        </div>
        <p class="search-tabs-row search-tabs-header">¡Al hacer clic en guardar, ambos actores aceptan los Términos y condiciones!</p>
    </div>
</section>
