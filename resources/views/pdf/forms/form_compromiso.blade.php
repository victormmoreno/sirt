{!! csrf_field() !!}
<input type="hidden" name="hddtipo" value="{{$tipo}}">
<input type="hidden" name="hddmodel" value="{{$model}}">
<div class="row">
    <div class="input-field col s12 m12 l12">
        <input id="txtfecha_reunion" name="txtfecha_reunion" value="" type="text" class="datepicker" required>
        <label for="txtfecha_reunion">Fecha de la reunión</label>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <input id="txthora_inicio" name="txthora_inicio" value="" type="time" required>
        <label class="active" for="txthora_inicio">Hora inicio de la reunión</label>
    </div>
    <div class="input-field col s12 m6 l6">
        <input id="txthora_fin" name="txthora_fin" value="" type="time" required>
        <label class="active" for="txthora_fin">Hora fin de la reunión</label>
    </div>
</div>
<div class="divider"></div>
<div class="center">
    <button type="submit" target="_blank" class="bg-secondary btn center-aling">
        <i class="material-icons right">file_download</i>
        Generar documento
    </button>
    <a href="{{url()->previous()}}" class="bg-danger btn center-aling">
        <i class="material-icons left">backspace</i>Volver
    </a>
</div>