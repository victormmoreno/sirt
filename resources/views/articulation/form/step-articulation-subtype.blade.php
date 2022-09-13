<h3>Tipo de subarticulación</h3>
<section>
    <div class="wizard-content">
        <div class="section-articulation search-tabs-row search-tabs-header">
            <div class="row">
                <div class="radio-buttons">
                    <h5>Seleccione un tipo de subarticulación</h5>

                    @forelse($articulationTypes  as $id => $name)
                        <label class="custom-radio">
                            @if (isset($articulacion))
                                <input type="radio" name="articulation_type" value="{{$id}}" {{ old('articulation_type', $articulacion->articulationtype->id) == $id ? 'checked':'' }} />
                            @else
                                <input type="radio" name="articulation_type" value="{{$id}}" {{ old('articulation_type') == $id ? 'checked':'' }} />
                            @endif
                            <span class="radio-btn">
                            <h3>{{$name}}</h3>
                        </span>
                        </label>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
