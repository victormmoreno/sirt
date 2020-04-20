{!! method_field('PUT')!!}
{!! csrf_field() !!}
<div class="row">
    <div class="input-field col s12 m6 l6">
        <input name="txtcodigo_articulacion" disabled
            value="{{ $articulacion->articulacion_proyecto->actividad->codigo_actividad }}" id="txtcodigo_articulacion">
        <label class="active" for="txtcodigo_articulacion">Código de la articulación</label>
    </div>
    <div class="input-field col s12 m6 l6">
        <input name="txtnombre" value="{{ $articulacion->articulacion_proyecto->actividad->nombre }}" disabled
            id="txtnombre" required>
        <label class="active" for="txtnombre">Nombre de la articulación</label>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <input name="txtgestor_id"
            value="{{ $articulacion->articulacion_proyecto->actividad->gestor->user->nombres }} {{ $articulacion->articulacion_proyecto->actividad->gestor->user->apellidos }}"
            disabled id="txtgestor_id">
        <label class="active" for="txtgestor_id">Gestor</label>
    </div>
    <div class="input-field col s12 m6 l6">
        <input name="txtlinea" id="txtlinea" value="{{$articulacion->articulacion_proyecto->actividad->gestor->lineatecnologica->abreviatura}} - {{$articulacion->articulacion_proyecto->actividad->gestor->lineatecnologica->nombre}}" disabled>
        <label class="active" for="txtlinea">Línea Tecnológica</label>
    </div>
</div>
<div class="row">
    <div class="card-panel green lighten-4 col s12 m6 l6 offset-m3 offset-l3">
        <div class="input-field col s12 m12 l12">
            <input {{$articulacion->articulacion_proyecto->aprobacion_dinamizador_suspender == 0 ? 'disabled' : ''}} type="text" name="txtfecha_cierre" id="txtfecha_cierre" value="{{ \Carbon\Carbon::now()->toDateString() }}" class="datepicker picker__input">
            <label for="txtfecha_cierre">Fecha de Cierre <span class="red-text">*</span></label>
            <small id="txtfecha_cierre-error" class="error red-text"></small>
          </div>
    </div>
</div>
@if ($articulacion->articulacion_proyecto->aprobacion_dinamizador_suspender == 0)
<div class="row">
    <div class="card-panel teal">
        <div class="dropzone" id="fase_suspendido_articulacion"></div>
    </div>
</div>
@endif
<div class="divider"></div>