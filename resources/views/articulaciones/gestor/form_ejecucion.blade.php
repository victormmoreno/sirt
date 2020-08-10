{!! method_field('PUT')!!}
{!! csrf_field() !!}
<div class="row">
    <h5 class="center">Entregables de la fase de ejecución</h5>
</div>
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
    <div class="col s6 m6 l6">
        <p class="p-v-xs">
            <input type="checkbox" {{$articulacion->articulacion_proyecto->aprobacion_dinamizador_ejecucion == 1 ? 'disabled' : '' }} {{ $articulacion->articulacion_proyecto->actividad->seguimiento == 1 ? 'checked' : '' }}
                id="txtseguimiento" name="txtseguimiento" value="1">
            <label for="txtseguimiento">
                Actas de seguimiento.
            </label>
        </p>
    </div>
    <div class="col s6 m6 l6">
        <h6>Para descargar el seguimiento y usos de infraestructura del proyecto, presiona el botón con el ícono <i class="far fa-file-pdf"></i></h6>
        <a class="btn green lighten-1 m-b-xs" href="{{route('pdf.actividad.usos', [$articulacion->id, 'articulacion'])}}" target="_blank"><i class="far fa-file-pdf"></i></a>
    </div>
</div>
@if ($articulacion->articulacion_proyecto->aprobacion_dinamizador_ejecucion == 0)
<div class="row">
    <div class="card-panel teal">
        <div class="dropzone" id="fase_ejecucion_articulacion"></div>
    </div>
</div>
@endif
<div class="divider"></div>