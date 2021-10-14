<div class="row">
  <input type="hidden" name="txtidea_id" value="{{$idea->id}}">
    <div class="input-field col s12 m6 l6">
      <select id="txtnodo_id" class="js-states" name="txtnodo_id" style="width: 100%;">
        <option value="">Seleccione el nodo</option>
        @foreach ($nodos as $nodo)
          <option value="{{$nodo->id}}" {{ $nodo->id == $idea->nodo->id ? 'selected' : '' }} {{ old('txtnodo_id') == $nodo->id ? 'selected':'' }} >{{$nodo->nodos}}</option>
        @endforeach
      </select>
      <label for="txtnodo_id">Nodos <span class="red-text">*</span></label>
      @error('txtnodo_id')
        <label id="txtnodo_id-error" class="error" for="txtnodo_id">{{ $message }}</label>
      @enderror
    </div>
    <div class="input-field col s12 m6 l6">
      <input disabled type="text" id="txtnombre_idea" name="txtnombre_idea" value="{{$idea->codigo_idea}} - {{ $idea->nombre_proyecto }}">
      <label for="txtnombre_idea">Idea de proyecto</label>
    </div>
  </div>
<div class="divider"></div>