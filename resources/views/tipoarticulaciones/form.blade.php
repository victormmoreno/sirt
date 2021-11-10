{!! csrf_field() !!}
<div class="row p-v-xs">
    <div class="input-field col s12">
        <input id="txtnombre" type="text" name="txtnombre" value="{{ isset($typeArticulation->nombre) ? $typeArticulation->nombre : old('txtnombre')}}" class="validate">
        <label for="txtnombre">Nombre del tipo de articulación<span class="red-text">*</span></label>
        <small id="txtnombre-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12">
        <textarea  name="txtdescripcion" class="materialize-textarea" length="5000" maxlength="5000" id="txtdescripcion">{{ isset($typeArticulation->descripcion) ? $typeArticulation->descripcion : old('txtdescripcion')}}</textarea>
        <label for="txtdescripcion">Descripción</label>
        <small id="txtdescripcion-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12">
        <input id="txtentidad" type="text" name="txtentidad" class="validate" value="{{ isset($typeArticulation->entidad) ? $typeArticulation->entidad : old('txtentidad')}}">
        <label for="txtentidad">Entidad (aparecerá por defecto)</label>
        <small id="txtentidad-error" class="error red-text"></small>
    </div>
    <div class="input-field col s12">
        <div class="switch p-v-xs">
            <label>
                Ocultar
                {{-- <input type="checkbox" name="checkestado" id="checkestado" checked> --}}
                @if(isset($typeArticulation->estado))
                <input type="checkbox" id="checkestado" name="checkestado" {{$typeArticulation->estado == App\Models\TipoArticulacion::mostrar() ? 'checked' : old('checkestado')}}>
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
    @foreach($nodos as $id => $name)
        <div class="col s12 m4 l3">
            <p class="p-h-xs p-v-xs">
                @if(isset($typeArticulation))
                <input type="checkbox" value="{{$id}}" {{collect(old('checknode',$typeArticulation->nodos->pluck('id')))->contains($id) ? 'checked' : ''  }} name="checknode[]" class="filled-in filled-in-node" id="filled-in-{{$id}}">
                @else
                <input type="checkbox" value="{{$id}}" name="checknode[]" class="filled-in filled-in-node" id="filled-in-{{$id}}" >
                @endif
                <label for="filled-in-{{$id}}">{{$name}}</label>
            </p>
        </div>
    @endforeach
    <small id="checknode-error" class="error red-text"></small>
</div>
<div class="row">
    <button type="submit" class="waves-effect waves-light btn orange m-b-xs right">{{isset($btnText) ? $btnText : 'Guardar'}}</button>
</div>
