{!! method_field('PUT')!!}
{!! csrf_field() !!}
@php
  $disabled = $articulacion->articulacion_proyecto->actividad->aprobacion_dinamizador == 1 ? 'disabled' : '';
@endphp
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<div class="row">
    <div class="input-field col s12 m6 l6">
        <input name="txtcodigo_articulacion" disabled
            value="{{ $articulacion->articulacion_proyecto->actividad->codigo_actividad }}" id="txtcodigo_articulacion">
        <label class="active" for="txtcodigo_articulacion">Código de la Articulacion</label>
    </div>
    <div class="input-field col s12 m6 l6">
        <input name="txtnombre" value="{{ $articulacion->articulacion_proyecto->actividad->nombre }}" disabled
            id="txtnombre" required>
        <label class="active" for="txtnombre">Nombre del Proyecto</label>
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
        <input name="txtlinea" id="txtlinea" value="{{ $articulacion->articulacion_proyecto->actividad->gestor->lineatecnologica->nombre }}" disabled>
        <label class="active" for="txtlinea">Línea Tecnológica</label>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <h5>Entregables Fase de Cierre</h5>
    <div class="col s6 m6 l6">
        <p class="p-v-xs">
            <input type="checkbox" {{ $disabled }} {{ $articulacion->informe_final == 1 ? 'checked' : '' }} id="txtinforme_final" name="txtinforme_final" value="1">
            <label for="txtinforme_final">Evidencias (en un solo archivo).</label>
        </p>
    </div>
    <div class="col s6 m6 l6">
        <p class="p-v-xs">
            <input type="checkbox" {{ $disabled }} {{ $articulacion->articulacion_proyecto->actividad->formulario_final == 1 ? 'checked' : '' }} id="txtformulario_final" name="txtformulario_final" value="1">
            <label for="txtformulario_final">Formularios con firmas del gestor y talentos.</label>
        </p>
    </div>
</div>
@if ($articulacion->articulacion_proyecto->actividad->aprobacion_dinamizador == 0)
<div class="row">
    <div class="card-panel teal">
        <div class="dropzone" id="fase_cierre_articulacion"></div>
    </div>
</div>
@endif
<div class="divider"></div>