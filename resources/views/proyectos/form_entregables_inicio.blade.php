{!! method_field('PUT')!!}
{!! csrf_field() !!}
@php
\Session::get('login_role') != App\User::IsGestor() ? $disabled = 'disabled' : $disabled = ''
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
        <label class="active" for="txtgestor_id">Gestor</label>
    </div>
    <div class="input-field col s12 m6 l6">
        <input name="txtlinea" id="txtlinea" value="{{ $proyecto->sublinea->linea->nombre }}" disabled>
        <label class="active" for="txtlinea">Línea Tecnológica</label>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <h5>Entregables Fase Inicio</h5>
    <div class="col s6 m3 l3">
        <p class="p-v-xs">
            <input type="checkbox" {{ $disabled }} {{ $proyecto->acc == 'Si' ? 'checked' : '' }} id="txtacc" name="txtacc" value="1">
            <label for="txtacc">Formato de confidencialidad y compromiso firmado.</label>
        </p>
    </div>
    <div class="col s6 m3 l3">
        <p class="p-v-xs">
            <input type="checkbox" {{ $disabled }} {{ $proyecto->manual_uso_inf == 'Si' ? 'checked' : '' }} id="txtmanual_uso_inf" name="txtmanual_uso_inf" value="1">
            <label for="txtmanual_uso_inf">Manual de uso de Infraestructura.</label>
        </p>
    </div>
    <div class="col s6 m3 l3">
        <p class="p-v-xs">
            <input type="checkbox" {{ $disabled }} {{ $proyecto->doc_titular == 'Si' ? 'checked' : '' }} id="txtdoc_titular" name="txtdoc_titular" value="1">
            <label for="txtdoc_titular">Documento del Titular.</label>
        </p>
    </div>
    <div class="col s6 m3 l3">
        <p class="p-v-xs">
            <input type="checkbox" {{ $disabled }} {{ $proyecto->formulario_inicio == 'Si' ? 'checked' : '' }} id="txtformulario_inicio" name="txtformulario_inicio" value="1">
            <label for="txtformulario_inicio">Formularios con firmas del gestor y talentos.</label>
        </p>
    </div>
</div>
<div class="row">
    <div class="card-panel teal">
        <div class="dropzone" id="fase_inicio_proyecto"></div>
    </div>
</div>
<div class="divider"></div>