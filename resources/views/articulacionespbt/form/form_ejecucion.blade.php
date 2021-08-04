{!! method_field('PUT')!!}
{!! csrf_field() !!}
<div class="row">
    <h5 class="center">Entregables de la fase de ejecución</h5>
</div>
<div class="divider"></div>
<div class="row">
    <div class="col s6 m6 l6">
        <p class="p-v-xs">
            <input type="checkbox" {{$articulacion->aprobacion_dinamizador_ejecucion == 1 ? 'disabled' : '' }} {{ $articulacion->seguimiento == 1 ? 'checked' : '' }}
                id="txtseguimiento" name="txtseguimiento" value="1">
            <label for="txtseguimiento">
                Seguimiento y Asesorias (se puede generar desde la plataforma)
        </p>
    </div>
    <div class="col s6 m6 l6">
        <h6>Para descargar el seguimiento y asesorias, presiona el botón con el ícono <i class="far fa-file-pdf"></i></h6>
        <a class="btn green lighten-1 m-b-xs" href="{{route('pdf.actividad.usos', [$articulacion->id, 'articulacion'])}}" target="_blank"><i class="far fa-file-pdf"></i></a>
    </div>
</div>
<div class="row">
    <div class="col s6 m6 l6">
        <p class="p-v-xs">
            <input type="checkbox" {{$articulacion->aprobacion_dinamizador_ejecucion == 1 ? 'disabled' : '' }} {{ $articulacion->present()->articulacionPbtDocumentoConvocatoria() == 1 ? 'checked' : '' }}
                id="txtdoc_convocatoria" name="txtdoc_convocatoria" value="1">
            <label for="txtdoc_convocatoria">
                Documentos de convocatoria
            </label>
        </p>
    </div>
</div>
@if ($articulacion->aprobacion_dinamizador_ejecucion == 0)
<div class="row">
    <div class="card-panel teal">
        <div class="dropzone" id="fase_ejecucion_articulacion"></div>
    </div>
</div>
@endif
<div class="divider"></div>
