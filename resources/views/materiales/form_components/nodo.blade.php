<div class="row">
    <div class="input-field col s12 m6 l6">
        <select style="width: 100%" class="js-states" id="txtnodo_id" name="txtnodo_id" onchange="consultarLineasNodo(this.value);">
        <option value="">Seleccione el nodo donde se registrará el material</option>
        @if (isset($material->nodo->id))
            @forelse ($nodos as $id => $nodo)
            <option value="{{$nodo->id}}" {{ $material->nodo_id == $nodo->id ? 'selected' : '' }}>{{$nodo->nodos}}</option>
            @empty
            <option value=""> No hay información disponible</option>
            @endforelse
        @else
            @forelse ($nodos as $id => $nodo)
            <option value="{{$nodo->id}}" {{ old('txtnodo_id') == $nodo->id ? 'selected':'' }}>{{$nodo->nodos}}</option>
            @empty
            <option value=""> No hay información disponible</option>
            @endforelse
        @endif
        </select>
        @error('txtnodo_id')
        <label class="error" for="txtnodo_id" id="txtnodo_id-error">
            {{ $message }}
        </label>
        @enderror
    </div>
    <div class="input-field col s12 m6 l6">
        <select style="width: 100%" class="js-states" id="txtlineatecnologica" name="txtlineatecnologica">
            <option value="">Seleccione la línea tecnológica donde se registrará el material de formación</option>
            @if (isset($material->lineatecnologica->id))
            @forelse ($lineastecnologicas as $id => $linea)
                <option value="{{$linea->id}}" {{ $material->lineatecnologica_id == $linea->id ? 'selected':'' }}>{{$linea->nombre}}</option>
                @empty
                <option value=""> No hay información disponible</option>
                @endforelse
            @endif
        </select>
        @error('txtlineatecnologica')
        <label class="error" for="txtlineatecnologica" id="txtlineatecnologica-error">
            {{ $message }}
        </label>
        @enderror
    </div>
</div>