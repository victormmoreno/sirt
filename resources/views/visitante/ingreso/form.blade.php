@if($errors->any())
  <div class="card red lighten-3">
    <div class="row">
      <div class="col s12 m12">
        <div class="card-content white-text">
          <p><i class="material-icons left"> info_outline</i>  Los datos marcados con * son obligatorios</p>
        </div>
      </div>
    </div>
  </div>
@endif
<div class="row">
  <div class="input-field col s12 m12 l12">
    <input name="txtdocumento"  id="txtdocumento" type="text" value="{{ isset($visitante) ? $visitante->documento : old('txtdocumento') }}">
    <label for="txtdocumento">Documento de Identidad <span class="red-text">*</span></label>
    @error('txtdocumento')
      <label id="txtdocumento-error" class="error" for="txtdocumento">{{ $message }}</label>
    @enderror
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <input type="text" id="txtnombres" name="txtnombres" value="{{ isset($visitante) ? $visitante->nombres : old('txtnombres') }}">
    <label for="txtnombres">Nombres <span class="red-text">*</span></label>
    @error('txtnombres')
      <label id="txtnombres-error" class="error" for="txtnombres">{{ $message }}</label>
    @enderror
  </div>
  <div class="input-field col s12 m6 l6">
    <input type="text" id="txtapellidos" name="txtapellidos" value="{{ isset($visitante) ? $visitante->apellidos : old('txtapellidos') }}">
    <label for="txtapellidos">Apellidos <span class="red-text">*</span></label>
    @error('txtapellidos')
      <label id="txtapellidos-error" class="error" for="txtapellidos">{{ $message }}</label>
    @enderror
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <select id="txttipodocumento_id" name="txttipodocumento_id" style="width: 100%">
      <option value="" selected="">Seleccione Tipo de Documento</option>
      @forelse ($tiposdocumento as $id => $value)
        @if (isset($visitante))
          <option value="{{ $id }}" {{ old('txttipodocumento_id', $visitante->tipodocumento_id) == $id ? 'selected': '' }}>{{$value}}</option>
        @else
          <option value="{{$id}}" {{ old('txttipodocumento_id') == $id ? 'selected' : '' }}>{{$value}}</option>
        @endif
      @empty
        <option value="">No hay información disponible</option>
      @endforelse
    </select>
    <label for="txttipodocumento_id">Tipo de Documento <span class="red-text">*</span></label>
    @error('txttipodocumento_id')
      <label id="txttipodocumento_id-error" class="error" for="txttipodocumento_id">{{ $message }}</label>
    @enderror
  </div>
  <div class="input-field col s12 m6 l6">
    <select id="txttipovisitante_id" name="txttipovisitante_id" style="width: 100%">
      <option value="" >Seleccione Tipo de Visitante</option>
      @forelse ($tiposvisitante as $id => $value)
        @if (isset($visitante))
          <option value="{{ $id }}" {{ old('txttipovisitante_id', $visitante->tipovisitante_id) == $id ? 'selected': '' }}>{{$value}}</option>
        @else
          <option value="{{$id}}" {{ old('txttipovisitante_id') == $id ? 'selected' : '' }}>{{$value}}</option>
        @endif
      @empty
        <option value="">No hay información disponible</option>
      @endforelse
    </select>
    <label for="txttipovisitante_id">Tipo de Visitante <span class="red-text">*</span></label>
    @error('txttipovisitante_id')
      <label id="txttipovisitante_id-error" class="error" for="txttipovisitante_id">{{ $message }}</label>
    @enderror
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <input type="text" id="txtcontacto" name="txtcontacto" value="{{ isset($visitante) ? $visitante->contacto : old('txtcontacto') }}">
    <label for="txtcontacto">Contacto</label>
    @error('txtcontacto')
      <label id="txtcontacto-error" class="error" for="txtcontacto">{{ $message }}</label>
    @enderror
  </div>
  <div class="input-field col s12 m6 l6">
    <input type="text" id="txtemail" name="txtemail" value="{{ isset($visitante) ? $visitante->email : old('txtemail') }}">
    <label for="txtemail">Correo Electrónico</label>
    @error('txtemail')
      <label id="txtemail-error" class="error" for="txtemail">{{ $message }}</label>
    @enderror
  </div>
</div>
<div class="divider"></div>
