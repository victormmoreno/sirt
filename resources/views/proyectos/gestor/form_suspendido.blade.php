{!! method_field('PUT')!!}
{!! csrf_field() !!}
<div class="row">
    <div class="input-field col s12 m6 l6">
        <input name="txtcodigo_proyecto" disabled
            value="{{ $proyecto->articulacion_proyecto->actividad->codigo_actividad }}" id="txtcodigo_proyecto">
        <label class="active" for="txtcodigo_proyecto">Código de Proyecto</label>
    </div>
    <div class="input-field col s12 m6 l6">
        <input name="txtnombre" value="{{ $proyecto->articulacion_proyecto->actividad->nombre }}" disabled
            id="txtnombre" required>
        <label class="active" for="txtnombre">Nombre del Proyecto</label>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <input name="txtgestor_id"
            value="{{ $proyecto->articulacion_proyecto->actividad->gestor->user->nombres }} {{ $proyecto->articulacion_proyecto->actividad->gestor->user->apellidos }}"
            disabled id="txtgestor_id">
        <label class="active" for="txtgestor_id">Experto</label>
    </div>
    <div class="input-field col s12 m6 l6">
        <input name="txtlinea" id="txtlinea" value="{{ $proyecto->sublinea->linea->nombre }}" disabled>
        <label class="active" for="txtlinea">Línea Tecnológica</label>
    </div>
</div>
<div class="row">
    <div class="card-panel green lighten-4 col s12 m6 l6 offset-m3 offset-l3">
        <div class="input-field col s12 m12 l12">
            <input {{$proyecto->articulacion_proyecto->aprobacion_dinamizador_suspender == 0 ? 'disabled' : ''}} type="text" name="txtfecha_cierre" id="txtfecha_cierre" value="{{ \Carbon\Carbon::now()->toDateString() }}" class="datepicker picker__input">
            <label for="txtfecha_cierre">Fecha de Cierre <span class="red-text">*</span></label>
            <small id="txtfecha_cierre-error" class="error red-text"></small>
          </div>
    </div>
</div>
@if ($proyecto->articulacion_proyecto->aprobacion_dinamizador_suspender == 0)
<div class="row">
    <div class="card-panel teal">
        <div class="dropzone" id="fase_suspendido_proyecto"></div>
    </div>
</div>
@endif
<div class="divider"></div>