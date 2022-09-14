<h3>Información Básica</h3>
<section>
    <div class="wizard-content">
        <div class="row search-tabs-row search-tabs-header">
            <div class="col m12">
                <h5><b>Ingresa la Información requerida</b></h5>
                <div class="row">
                    @can('listNodes', App\Models\ArticulationStage::class)
                    <div class="input-field col s3">
                        <select name="node"  style="width: 100%" tabindex="-1">
                            <option value="">Seleccione el nodo</option>
                            @foreach($nodos as $id => $name)
                                @if(isset($articulationSubtype->nodos))
                                    <option value="{{$id}}" {{collect(old('node',$typeArticulation->nodos->pluck('id')))->contains($id)  ? 'selected' : '' }}>{{$name}}</option>
                                @else
                                    <option value="{{$id}}" {{old('node') == $id ? 'selected':''}}>{{$name}}</option>
                                @endif
                            @endforeach
                        </select>
                        <label for="articulationtype">Nodo <span class="red-text">*</span></label>
                        <small id="node-error" class="error red-text"></small>
                    </div>
                    @endcan
                    <div class="input-field col @can('listNodes', App\Models\ArticulationStage::class) s9  @else s12 @endcan">
                        <label for="name">{{ __('Name ArticulationStage') }}<span class="red-text">*</span></label>
                        <input id="name" name="name" type="text"value="{{ old('name', isset($articulationStage->name) ? $articulationStage->name: '') }}">
                    </div>
                    <div class="input-field col m12 s12">
                        <label for="description">{{ __('Description') }} (Opcional)</label>
                        <textarea id="description" name="description" type="text" class="materialize-textarea">{{ old('description', isset($articulationStage->description) ? $articulationStage->description: '') }}</textarea>
                    </div>
                    <div class="input-field col m12 s12">
                        <label for="scope"> {{ __('Scope') }}<span class="red-text">*</span></label>
                        <textarea id="scope" name="scope" type="text" class="materialize-textarea">{{ old('scope', isset($articulationStage->scope) ? $articulationStage->scope : '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
