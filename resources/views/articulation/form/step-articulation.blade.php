<h3>Información básica</h3>
<section>
    <div class="wizard-content">
        <div class="section-articulation search-tabs-row search-tabs-header">
            <div class="col m12">
                <div class="row">
                    <div class="input-field col s6">
                        <select id="articulation_type" name="articulation_type"  style="width: 100%" tabindex="-1">
                            <option value="">Seleccione tipo de articulación</option>
                            @foreach($articulationTypes as $id => $name)
                                @if(isset($articulation))
                                    <option value="{{$id}}" {{old('articulation_type',$articulation->articulationsubtype->articulationtype->id) == $id ? 'selected':''}}>{{$name}}</option>
                                @else
                                    <option value="{{$id}}" {{old('articulation_type') == $id ? 'selected':''}}>{{$name}}</option>
                                @endif
                            @endforeach
                        </select>
                        <label for="articulation_type">Tipo de articulación <span class="red-text">*</span></label>
                        <small id="articulation_type-error" class="error red-text"></small>
                    </div>
                    <div class="input-field col s6">
                        <select id="articulation_subtype" name="articulation_subtype"  style="width: 100%" tabindex="-1">
                            <option value="">Primero selecciona el tipo de articulacion</option>
                        </select>
                        <label for="articulation_subtype">Tipo de subarticulación <span class="red-text">*</span></label>
                        <small id="articulation_subtype-error" class="error red-text"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l12">
                        @if(isset($articulation))
                            <input  id="start_date" name="start_date" type="text" class="datepicker_articulation_max_date" value="{{$articulation->start_date->format('Y-m-d')}}">
                        @else
                            <input id="start_date" name="start_date" type="text" class="datepicker_articulation_max_date">
                        @endif
                        <label for="start_date">Fecha de inicio articulación<span class="red-text">*</span></label>
                        <small id="start_date-error" class="error red-text"></small>
                    </div>
                    <div class="input-field col m12 s12">
                        <label for="name">Nombre acción de Articulación <span class="red-text">*</span></label>
                        <input id="name" name="name" value="{{isset($articulation) ? $articulation->name : old('name')}}" type="text">
                    </div>
                    <div class="input-field col m12 s12">
                        <label for="description">{{ __('Description') }} <span class="red-text">*</span></label>
                        <textarea id="description" name="description"  type="text" class="materialize-textarea validate">{{isset($articulation) ? $articulation->description : old('description')}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
