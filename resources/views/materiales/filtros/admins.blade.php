<div class="row">
    <div class="col s12 m12 l12">
        <label class="active" for="selectnodo">Nodo <span class="red-text">*</span></label>
        <select class="js-states browser-default select2 " onchange="selectMaterialesPorNodo.selectMaterialesForNodo()" tabindex="-1" style="width: 100%" id="selectnodo" >
            <option value="">Seleccione nodo</option>
            @foreach($nodos as $nodo)
              <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
            @endforeach
        </select>
    </div>
</div>