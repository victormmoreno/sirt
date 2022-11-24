{!! csrf_field() !!}
<div class="row p-v-xs">
    <div class="input-field col s6">
        <select name="articulationtype"  style="width: 100%" tabindex="-1">
            <option value="">Seleccione tipo de articulación</option>
            @foreach($articulationTypes as $id => $name)
                @if(isset($articulationSubtype->articulationtype->id))
                    <option value="{{$id}}" {{old('articulationtype',$articulationSubtype->articulationtype->id) ==$id ? 'selected':''}}>{{$name}}</option>
                @else
                    <option value="{{$id}}" {{old('articulationtype') == $id ? 'selected':''}}>{{$name}}</option>
                @endif
            @endforeach
        </select>
        <label for="articulationtype">Tipo de articulación <span class="red-text">*</span></label>
        <small id="articulationtype-error" class="error red-text"></small>
    </div>
    <div class="input-field col s6">
        <input id="name" type="text" name="name" value="{{ isset($articulationSubtype->name) ? $articulationSubtype->name : old('name')}}" class="validate">
        <label for="name">Nombre del tipo de subarticulación<span class="red-text">*</span></label>
        <small id="name-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12">
        <textarea  name="description" class="materialize-textarea" length="5000" maxlength="5000" id="description">{{ isset($articulationSubtype->description) ? $articulationSubtype->description : old('description')}}</textarea>
        <label for="description">Descripción</label>
        <small id="description-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12">
        <input id="entity" type="text" name="entity" class="validate"  value="{{ isset($articulationSubtype->entity) ? collect($articulationSubtype->entity)->implode(', ') : old('entity')}}" placeholder="Ingrese las entidades separadas por comas (,)">
        <label for="entity">Entidades promotoras (seperadas por comas)<span class="red-text">*</span></label>
        <small id="entity-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12">
        <div class="switch p-v-xs">
            <label>
                Ocultar
                @if(isset($articulationSubtype->state))
                    <input type="checkbox" id="checkestado" name="checkestado" {{$articulationSubtype->state == App\Models\ArticulationSubtype::mostrar() ? 'checked' : old('checkestado')}}>
                @else
                    <input type="checkbox" id="checkestado" name="checkestado" {{old('checkestado') == 'on' ? '' : 'checked'}}>
                @endif
                <span class="lever"></span>
                Mostrar
            </label>
        </div>
    </div>
</div>
<small id="checkestado-error" class="error red-text"></small>
<div class="row p-v-xs">
    <address class=" p-v-xs left left-align">
        <strong>Nodos</strong><br>
        <p>Selecciona los nodos donde se va a presentar este tipo de articulación</p>
    </address>
    <p class="p-h-xs p-v-xs right right-align">
            <input type="checkbox" class="filled-in " id="check-all-nodes">
            <label for="check-all-nodes">Seleccionar todos los nodos</label>
    </p>
</div>
<div class="row p-v-xs">
    @forelse ($nodos as $nodo)
        <div class="col s12 m4 l3">
            <p class="p-h-xs p-v-xs">
                @if(isset($articulationSubtype))
                    <input type="checkbox" value="{{ $nodo->id }}" {{collect(old('checknode',$articulationSubtype->nodos->pluck('id')))->contains($nodo->id) ? 'checked' : ''  }} name="checknode[]" class="filled-in filled-in-node" id="filled-in-{{$nodo->id}}">
                @else
                    <input type="checkbox" value="{{ $nodo->id }}" name="checknode[]" class="filled-in filled-in-node" id="filled-in-{{$nodo->id}}" >
                @endif
                <label for="filled-in-{{$nodo->id}}">{{$nodo->nodos}}</label>
            </p>
        </div>
    @empty
        <div class="col s12 m4 l3">
            <p class="p-h-xs p-v-xs">{{__('No results found')}}</p>
        </div>
    @endforelse
</div>
<div class="row">
    <small id="checknode-error" class="error red-text"></small>
</div>
<div class="row">
    <button type="submit" class="waves-effect waves-teal bg-secondary white-text btn-flat m-t-xs right">{{isset($btnText) ? $btnText : 'Guardar'}}</button>
</div>

