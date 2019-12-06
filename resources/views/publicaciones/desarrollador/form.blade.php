{!! csrf_field() !!}
<div class="divider"></div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <label for="txttitulo">Título de la Publicación <span class="red-text">*</span></label>
    <input type="text" id="txttitulo" name="txttitulo" value="{{ isset($publicacion) ? $publicacion->titulo : '' }}"/>
    <small id="txttitulo-error" class="error red-text"></small>
  </div>
  <div class="input-field col s12 m6 l6">
    <select class="js-states" id="txtrole_id" name="txtrole_id">
      <option value="">Seleccione el Rol</option>
      @forelse ($roles as $id => $value)
        @if (isset($publicacion))
          <option value="{{ $id }}" {{ $publicacion->role_id == $id ? 'selected': '' }}>{{$value}}</option>
        @else
          <option value="{{$id}}">{{$value}}</option>
        @endif
      @empty
        <option value="">No hay información disponible</option>
      @endforelse
    </select>
    <label for="txtrole_id">Rol <span class="red-text">*</span></label>
    <small id="txtrole_id-error" class="error red-text"></small>
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <input type="text" id="txtfecha_inicio" href="javascript:void(0)" name="txtfecha_inicio" value="{{ isset($publicacion) ? $publicacion->fecha_inicio : '' }}"/>
    <label for="txtfecha_inicio">Fecha de inicio de la publicación<span class="red-text">*</span></label>
    <small id="txtfecha_inicio-error" class="error red-text"></small>
  </div>
  <div class="input-field col s12 m6 l6">
    <input type="text" id="txtfecha_fin" href="javascript:void(0)" name="txtfecha_fin" value="{{ isset($publicacion) ? $publicacion->fecha_fin : '' }}"/>
    <label for="txtfecha_fin">Fecha de terminación de la publicación <span class="red-text">*</span></label>
    <small id="txtfecha_fin-error" class="error red-text"></small>
  </div>
</div>
<div class="row">
  <h5 class="center">Contenido</h5>
  <div class="input-field col s12 m12 l8 offset-l2">
    <textarea id="txtcontenido" name="txtcontenido" class="materialize-textarea">{{ isset($publicacion) ? $publicacion->contenido : '' }}</textarea>
    {{-- <label for="txtcontenido">Contenido</label> --}}
    <small id="txtcontenido-error" class="error red-text"></small>
  </div>
</div>
<div class="divider"></div>
