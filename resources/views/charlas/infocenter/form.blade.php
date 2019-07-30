@if ($errors->any())
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
<div class="divider"></div>
<div class="row">
  <div class="input-field col s12 m3 l3">
    <i class="material-icons prefix">location_city</i>
    <input id="txtfecha" type="text" value="{{ isset($charla) ? Carbon\Carbon::parse($charla->fecha) : old('txtfecha', Carbon\Carbon::now()->toDateString()) }}" name="txtfecha" class="datepicker picker__input">
    <label for="txtfecha">Fecha de la Charla Informativa <span class="red-text">*</span></label>
    @error('txtfecha')
      <label id="txtfecha-error" class="error" for="txtfecha">{{ $message }}</label>
    @enderror
  </div>
  <div class="input-field col s12 m3 l3">
    <i class="material-icons prefix">location_city</i>
    <input id="txtnro_asistentes" type="number" name="txtnro_asistentes" value="{{ isset($charla) ? $charla->nro_asistentes : old('txtfecha') }}">
    <label for="txtnro_asistentes">Número de Asistentes <span class="red-text">*</span></label>
    @error('txtnro_asistentes')
      <label id="txtnro_asistentes-error" class="error" for="txtnro_asistentes">{{ $message }}</label>
    @enderror
  </div>
  <div class="input-field col s12 m6 l6">
    <i class="material-icons prefix">date_range</i>
    <input id="txtencargado" type="text" name="txtencargado" value="{{ isset($charla) ? $charla->encargado : old('txtencargado') }}" length="75" maxlength="75">
    <label for="txtencargado">Encargado(a) de la Charla Informativa <span class="red-text">*</span></label>
    @error('txtencargado')
      <label id="txtencargado-error" class="error" for="txtencargado">{{ $message }}</label>
    @enderror
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m12 l12">
    <i class="material-icons prefix">speaker_notes</i>
    <textarea name="txtobservacion" class="materialize-textarea" length="1000" maxlength="1000" id="txtobservacion" >{{ isset($charla) ? $charla->observacion : '' }}</textarea>
    <label for="txtobservacion">Observaciones de la Charla Informativa</label>
    @error('txtobservacion')
      <label id="txtobservacion-error" class="error" for="txtobservacion">{{ $message }}</label>
    @enderror
  </div>
</div>
<div class="divider"></div>
<center>
  <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">{{ isset($btnText) ? $btnText == 'Modificar' ? 'done' : 'done_all' : '' }}</i>{{isset($btnText) ? $btnText : 'error'}}</button>
  <a href="{{route('charla')}}" class="btn waves-effect red lighten-2  center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
</center>
