<div class="center">
    <span class="mailbox-title orange-text">
        <i class="material-icons">attach_file</i>
        Evidencias de la fase de ejecución.
    </span>
</div>
<div class="divider mailbox-divider"></div>
<div class="row">
    <div class="col s6 m6 l6">
        <p class="p-v-xs">
            <input type="checkbox" disabled {{ $actividad->seguimiento == 1 ? 'checked' : '' }}
                id="txtseguimiento" name="txtseguimiento" value="1">
            <label for="txtseguimiento">
                Seguimiento y usos de infraestructuras.
            </label>
        </p>
    </div>
    <div class="col s6 m6 l6">
        <p class="p-v-xs">
            <input type="checkbox" disabled {{ $actividad->articulacionpbt->present()->articulacionPbtDocumentoConvocatoria() == 1 ? 'checked' : '' }}
                id="txtdoc_convocatoria" name="txtdoc_convocatoria" value="1">
            <label for="txtdoc_convocatoria">
                Documentos de convocatoria 
            </label>
        </p>
    </div>
</div>
<div class="row">
    @include('articulacionespbt.table-archive-fase', ['fase' => 'ejecucion'])
</div>