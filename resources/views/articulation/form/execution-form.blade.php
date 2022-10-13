{!! method_field('PUT')!!}
{!! csrf_field() !!}
<div class="row">
    <h5 class="center">Entregables de la fase de ejecución</h5>
</div>
<div class="divider"></div>
<div class="row">
    <div class="col s6 m6 l6">
        <p class="p-v-xs">
            <input type="checkbox"  {{ $articulation->tracing == 1 ? 'checked' : '' }}
            id="tracing" name="tracing" value="1">
            <label for="tracing">
                Seguimiento y Asesorias (se puede generar desde la plataforma)
        </p>
    </div>
    <div class="col s6 m6 l6">
        <h6>Para descargar el seguimiento y asesorias, presiona el botón con el ícono <i class="far fa-file-pdf"></i></h6>
        <a class="btn green lighten-1 m-b-xs" href="{{route('pdf.actividad.usos', [$articulation->id, 'articulacion'])}}" target="_blank"><i class="far fa-file-pdf"></i></a>
    </div>
</div>
<div class="row">
    <div class="col s6 m6 l6">
        <p class="p-v-xs">
            <input type="checkbox" {{ $articulation->announcement_document == 1 ? 'checked' : '' }}
            id="announcement_document" name="announcement_document" value="1">
            <label for="announcement_document">
                Documentos de convocatoria
            </label>
        </p>
    </div>
</div>
<div class="row">
        <div class="dropzone" id="fase_ejecucion_articulacion"></div>
</div>
