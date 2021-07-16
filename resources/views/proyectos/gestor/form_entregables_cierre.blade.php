{!! method_field('PUT')!!}
{!! csrf_field() !!}
@php
  $disabled = $proyecto->articulacion_proyecto->actividad->aprobacion_dinamizador == 1 ? 'disabled' : '';
@endphp
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
<div class="divider"></div>
<div class="row">
    <h5>Entregables Fase de Cierre</h5>
    <div class="col s6 m6 l6">
        <p class="p-v-xs">
            <input type="checkbox" {{ $disabled }} {{ $proyecto->evidencia_trl == 1 ? 'checked' : '' }} id="txtevidencia_trl" name="txtevidencia_trl" value="1">
            <label for="txtevidencia_trl">Evidencias según trl.</label>
        </p>
    </div>
    <div class="col s6 m6 l6">
        <p class="p-v-xs">
            <input type="checkbox" {{ $disabled }} {{ $proyecto->articulacion_proyecto->actividad->formulario_final == 1 ? 'checked' : '' }} id="txtformulario_final" name="txtformulario_final" value="1">
            <label for="txtformulario_final">Acta de Cierre. (se puede generar desde la plataforma)</label>
        </p>
    </div>
</div>
@if ($proyecto->articulacion_proyecto->actividad->aprobacion_dinamizador == 0)
<div class="row">
    <div class="card-panel teal">
        <div class="dropzone" id="fase_cierre_proyecto"></div>
    </div>
</div>
@endif
<div class="divider"></div>