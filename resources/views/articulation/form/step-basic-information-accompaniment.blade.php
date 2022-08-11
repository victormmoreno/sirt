<h3>Información Básica</h3>
<section>
    <div class="wizard-content">
        <div class="row search-tabs-row search-tabs-header">
            <div class="col m12">
                <h5><b>Ingresa la Información requerida</b></h5>
                <div class="row">
                    <div class="input-field col m12 s12">
                        <label for="name">{{ __('Name Accompaniment') }}<span class="red-text">*</span></label>
                        <input id="name" name="name" type="text"value="{{ old('name', isset($accompaniment->name) ? $accompaniment->name: '') }}">
                    </div>
                    <div class="input-field col m12 s12">
                        <label for="description">{{ __('Description') }} (Opcional)</label>
                        <textarea id="description" name="description" type="text" class="materialize-textarea">{{ old('description', isset($accompaniment->description) ? $accompaniment->description: '') }}</textarea>
                    </div>
                    <div class="input-field col m12 s12">
                        <label for="scope"> {{ __('Scope') }}<span class="red-text">*</span></label>
                        <textarea id="scope" name="scope" type="text" class="materialize-textarea">{{ old('scope', isset($accompaniment->scope) ? $accompaniment->scope : '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
