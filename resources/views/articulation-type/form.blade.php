{!! csrf_field() !!}
<div class="row p-v-xs">
    <div class="input-field col s12">
        <input id="name" type="text" name="name"
               value="{{ isset($typeArticulation->name) ? $typeArticulation->name : old('name')}}"
               class="validate">
        <label for="name">Nombre del tipo de articulación<span class="red-text">*</span></label>
        <small id="name-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12">
        <textarea name="description" class="materialize-textarea" length="5000" maxlength="5000"
                  id="description">{{ isset($typeArticulation->description) ? $typeArticulation->description : old('description')}}</textarea>
        <label for="description">Descripción</label>
        <small id="description-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12">
        <div class="switch p-v-xs">
            <label>
                Ocultar
                @if(isset($typeArticulation->state))
                    <input type="checkbox" id="checkestado"
                           name="checkestado" {{$typeArticulation->state == App\Models\ArticulationType::mostrar() ? 'checked' : old('checkestado')}}>
                @else
                    <input type="checkbox" id="checkestado"
                           name="checkestado" {{old('checkestado') == 'on' ? '' : 'checked'}}>
                @endif
                <span class="lever"></span>
                Mostrar
            </label>
        </div>
    </div>
</div>
<small id="checkestado-error" class="error red-text"></small>
<div class="row">
    <button type="submit"
            class="waves-effect waves-teal bg-secondary white-text btn-flat m-t-xs right">{{isset($btnText) ? $btnText : 'Guardar'}}</button>
</div>
