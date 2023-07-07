{!! method_field('PUT')!!}
{!! csrf_field() !!}
<div class="row">
    <h5 class="center">Entregables de la fase de ejecución</h5>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <input name="txtcodigo_proyecto" disabled
            value="{{ $proyecto->present()->proyectoCode() }}" id="txtcodigo_proyecto">
        <label class="active" for="txtcodigo_proyecto">Código de Proyecto</label>
    </div>
    <div class="input-field col s12 m6 l6">
        <input name="txtnombre" value="{{ $proyecto->present()->proyectoName() }}" disabled
            id="txtnombre" required>
        <label class="active" for="txtnombre">Nombre del Proyecto</label>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <input name="txtgestor_id"
            value="{{ $proyecto->present()->proyectoUserAsesor() }}"
            disabled id="txtgestor_id">
        <label class="active" for="txtgestor_id">Experto</label>
    </div>
    <div class="input-field col s12 m6 l6">
        <input name="txtlinea" id="txtlinea" value="{{ $proyecto->present()->proyectoLinea() }}" disabled>
        <label class="active" for="txtlinea">Línea Tecnológica</label>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <div class="col s6 m6 l6">
        <p class="p-v-xs">
            <input type="checkbox"{{ $proyecto->seguimiento == 1 ? 'checked' : '' }}
                id="txtseguimiento" name="txtseguimiento" value="1">
            <label for="txtseguimiento">
                Seguimiento y usos de infraestructura.
            </label>
        </p>
    </div>
    <div class="col s6 m6 l6">
        <h6>Para descargar el seguimiento y usos de infraestructura de la articulación, presiona el botón con el ícono <i class="far fa-file-pdf"></i></h6>
        <a class="btn green lighten-1 m-b-xs" href="{{route('pdf.actividad.usos', [$proyecto->id, 'proyecto'])}}" target="_blank"><i class="far fa-file-pdf"></i></a>
    </div>
</div>
<div class="row">
    <div class="card-panel teal">
        <div class="dropzone" id="fase_ejecucion_proyecto"></div>
    </div>
</div>
<div class="divider"></div>
