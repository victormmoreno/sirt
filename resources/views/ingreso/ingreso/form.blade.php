<div class="row">
  <div class="input-field col s11 m11 l11">
    <input name="txtdocumento"  id="txtdocumento" type="text" value="{{ isset($ingreso) ? $visitante->documento : '' }}">
    <label for="txtdocumento">Documento <span class="red-text">*</span></label>
    <small id="txtdocumento-error" class="error red-text"></small>
  </div>
  <div class="col s1 m1 l1">
    <a class="btn-floating btn-large waves-effect tooltipped waves-light blue" data-position="bottom" data-delay="50" data-tooltip="Verificar" id="btnNumeroIdentificacion" onclick="consultarVisitanteTecnoparque()"><i class="material-icons">search</i></a>
  </div>
</div>
<div id="divRegistrarVisitante" class="card-panel orange lighten-5">
  <h4 class="center">Registrar nuevo visitante</h4>
  <div class="divider"></div>
  <br />
  @include('visitante.ingreso.form')
</div>
<div id="divVisitanteRegistrado" class="card-panel green lighten-5">
  <h4 class="center">Visitante Registrado</h4>
  <div class="divider"></div>
  <div class="row">
    <div class="input-field col s12 m6 l6">
      <small>Nombre Completo</small>
      <input type="text" name="nombrePersona" id="nombrePersona" disabled>
    </div>
    <div class="input-field col s12 m6 l6">
      <small>Tipo de persona</small>
      <input type="text" name="tipoPersona" id="tipoPersona" disabled>
    </div>
  </div>
  <div class="row">
    <div class="input-field col s12 m6 l6">
      <small>Contacto</small>
      <input type="text" name="contactoReg" id="contactoReg" disabled>
    </div>
    <div class="input-field col s12 m6 l6">
      <small>Correo Electrónico</small>
      <input type="email" id="correoReg" name="correoReg" disabled>
    </div>
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <input type="text" name="txtfecha_ingreso" id="txtfecha_ingreso" value="{{ Carbon\Carbon::now()->toDateString() }}" class="datepicker picker__input">
    <label for="txtfecha_ingreso">Fecha de Ingreso <span class="red-text">*</span></label>
    <small id="txtfecha_ingreso-error" class="error red-text"></small>
  </div>
  <div class="input-field col s12 m6 l6">
    <input id="txthora_entrada" type="time" class="pickertime" name="txthora_entrada" value="{{ isset($ingreso) ? $ingreso->txthora_entrada : Carbon\Carbon::now()->isoFormat('hh:mm') }}">
    <label for="txthora_entrada" class="active">Hora de Ingreso <span class="red-text">*</span></label>
    <small id="txthora_entrada-error" class="error red-text"></small>
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <select id="txtservicio_id" name="txtservicio_id" style="width: 100%;">
      <option value="">Seleccione un Servicio</option>
      @forelse ($servicios as $id => $value)
        @if (isset($ingreso))
          <option value="{{ $id }}" {{ $ingreso->servicio_id == $id ? 'selected': '' }}>{{$value}}</option>
        @else
          <option value="{{$id}}">{{$value}}</option>
        @endif
      @empty
        <option value="">No hay información disponible</option>
      @endforelse
    </select>
    <label for="txtservicio_id">Servicio <span class="red-text">*</span></label>
    <small id="txtservicio_id-error" class="error red-text"></small>
  </div>
  <div class="input-field col s12 m6 l6">
    <input type="time" class="pickertime" id="txthora_salida" name="txthora_salida" value="{{ isset($ingreso) ? $ingreso->hora_salida : old('txthora_salida') }}">
    <label for="txthora_salida" class="active">Hora Salida <span class="red-text">*</span></label>
    <small id="txthora_salida-error" class="error red-text"></small>
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m12 l12">
    <input type="text" id="txtdescripcion" name="txtdescripcion" length="200" maxlength="200" value="{{ isset($ingreso) ? $ingreso->descripcion : old('txtapellidos') }}">
    <label for="txtdescripcion">Descripción</label>
    <small id="txtdescripcion-error" class="error red-text"></small>
  </div>
</div>
<div class="divider"></div>
<center>
  <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>Registrar</button>
  <a href="{{route('ingreso')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
</center>
