<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<div class="row">
  <div class="input-field col s11 m11 l11">
    <input name="txtdocumento"  id="txtdocumento" type="text" value="{{ isset($ingreso) ? $visitanteIng->documento : '' }}">
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
  @include('visitante.form')
</div>
<div id="divVisitanteRegistrado" class="card-panel green lighten-5">
  <h4 class="center">Visitante Registrado</h4>
  <div class="divider"></div>
  <div class="row">
    <div class="input-field col s12 m6 l6">
      <input type="text" name="nombrePersona" id="nombrePersona" value="{{ isset($visitanteIng) ? $visitanteIng->nombres .' '. $visitanteIng->apellidos : '' }}" disabled>
      <label class="active" for="nombrePersona">Nombre Completo del Visitante</label>
    </div>
    <div class="input-field col s12 m6 l6">
      <input type="text" name="tipoPersona" id="tipoPersona" value="{{ isset($visitanteIng) ? $visitanteIng->tipovisitante : '' }}" disabled>
      <label class="active" for="tipoPersona">Tipo de persona</label>
    </div>
  </div>
  <div class="row">
    <div class="input-field col s12 m6 l6">
      <input type="text" name="contactoReg" id="contactoReg" value="{{ isset($visitanteIng) ? $visitanteIng->contacto : '' }}" disabled>
      <label class="active" for="contactoReg">Contacto</label>
    </div>
    <div class="input-field col s12 m6 l6">
      <input type="email" id="correoReg" name="correoReg" value="{{ isset($visitanteIng) ? $visitanteIng->email : '' }}" disabled>
      <label class="active" for="correoReg">Correo Electrónico</label>
    </div>
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <input type="text" name="txtfecha_ingreso" id="txtfecha_ingreso" value="{{ isset($ingreso) ? Carbon\Carbon::parse($ingreso->fecha_ingreso)->toDateString() : Carbon\Carbon::now()->toDateString() }}" class="datepicker picker__input">
    <label for="txtfecha_ingreso">Fecha de Ingreso <span class="red-text">*</span></label>
    <small id="txtfecha_ingreso-error" class="error red-text"></small>
  </div>
  <div class="input-field col s12 m6 l6">
    <input id="txthora_entrada" type="time" class="pickertime" name="txthora_entrada" value="{{ isset($ingreso) ? Carbon\Carbon::parse($ingreso->fecha_ingreso)->isoFormat('hh:mm') : Carbon\Carbon::now()->isoFormat('hh:mm') }}">
    <label for="txthora_entrada" class="active">Hora de Ingreso <span class="red-text">*</span></label>
    <small id="txthora_entrada-error" class="error red-text"></small>
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <select id="txtservicio_id" name="txtservicio_id" style="width: 100%;">
      <option value="">Seleccione a que viene</option>
      @forelse ($servicios as $id => $value)
        @if (isset($ingreso))
          <option value="{{ $value->id }}" {{ $ingreso->servicio_id == $value->id ? 'selected': '' }}>{{$value->nombre}} {{$value->descripcion != null ? '('.$value->descripcion.')' : ''}}</option>
        @else
          <option value="{{$value->id}}">{{$value->nombre}} {{$value->descripcion != null ? '('.$value->descripcion.')' : ''}}</option>
        @endif
      @empty
        <option value="">No hay información disponible</option>
      @endforelse
    </select>
    <label for="txtservicio_id">¿A qué viene? <span class="red-text">*</span></label>
    <small id="txtservicio_id-error" class="error red-text"></small>
  </div>
  <div class="input-field col s12 m6 l6">
    <input type="time" class="pickertime" id="txthora_salida" name="txthora_salida" value="{{ isset($ingreso) ? Carbon\Carbon::parse($ingreso->hora_salida)->isoFormat('hh:mm') : old('txthora_salida') }}">
    <label for="txthora_salida" class="active">Hora Salida</label>
    <small id="txthora_salida-error" class="error red-text"></small>
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <input type="text" id="txtautoriza" name="txtautoriza" length="200" maxlength="200" value="{{ isset($ingreso) ? $ingreso->quien_autoriza : old('txtautoriza') }}">
    <label for="txtautoriza">¿Quién autoriza la entrada?</label>
    <small id="txtautoriza-error" class="error red-text"></small>
  </div>
  <div class="input-field col s12 m6 l6">
    <input type="text" id="txtdescripcion" name="txtdescripcion" length="200" maxlength="200" value="{{ isset($ingreso) ? $ingreso->descripcion : old('txtdescripcion') }}">
    <label for="txtdescripcion">Descripción <span class="red-text">*</span></label>
    <small id="txtdescripcion-error" class="error red-text"></small>
  </div>
</div>
<div class="divider"></div>
<center>
  <button type="submit" class="waves-effect btn bg-secondary center-aling"><i class="material-icons right">send</i>Guardar</button>
  <a href="{{route('ingreso')}}" class="waves-effect btn bg-danger center-aling"><i class="material-icons left">backspace</i>Cancelar</a>
</center>
