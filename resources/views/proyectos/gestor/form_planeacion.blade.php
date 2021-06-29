{!! method_field('PUT')!!}
{!! csrf_field() !!}
<div class="row">
    <h5 class="center">Entregables de la fase de planeación</h5>
</div>
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
    <div class="col s6 m6 l6">
        <p class="p-v-xs">
            <input type="checkbox" {{$proyecto->fase->nombre != 'Planeación' ? 'disabled' : '' }} {{ $proyecto->articulacion_proyecto->actividad->cronograma == 1 ? 'checked' : '' }} id="txtcronograma" name="txtcronograma" value="1">
            <label for="txtcronograma">Cronograma de trabajo.</label>
        </p>
    </div>
    <div class="col s6 m6 l6">
        <p class="p-v-xs">
            <input type="checkbox" {{$proyecto->fase->nombre != 'Planeación' ? 'disabled' : '' }} {{ $proyecto->estado_arte == 1 ? 'checked' : '' }} id="txtestado_arte" name="txtestado_arte" value="1">
            <label for="txtestado_arte">Estado del arte.</label>
        </p>
    </div>
</div>
@if ($proyecto->fase->nombre == 'Planeación')
<div class="row">
    <div class="card-panel teal">
        <div class="dropzone" id="fase_planeacion_proyecto"></div>
    </div>
</div>
@endif
<div class="divider"></div>