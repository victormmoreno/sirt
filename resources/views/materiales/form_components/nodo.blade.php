<div class="row">
    <div class="input-field col s12 m6 l6">
        <select style="width: 100%" class="js-states" id="txtnodo_id" name="txtnodo_id" onchange="consultarLineasNodo(this.value);">
        <option value="">Seleccione el nodo donde se registrará el material</option>
        @if (isset($material->nodo->id))
            @forelse ($nodos as $id => $nodo)
            <option value="{{$id}}" {{ $material->nodo_id == $id ? 'selected' : '' }}>{{$nodo->nodos}}</option>
            @empty
            <option value=""> No hay información disponible</option>
            @endforelse
        @else
            @forelse ($nodos as $id => $nodo)
            <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
            @empty
            <option value=""> No hay información disponible</option>
            @endforelse
        @endif
    </select>
    </div>
    <div class="input-field col s12 m6 l6">
        <select style="width: 100%" class="js-states" id="txtlineatecnologica" name="txtlineatecnologica">
            <option value="">Seleccione la línea tecnológica donde se registrará el material de formación</option>
        </select>
    </div>
</div>