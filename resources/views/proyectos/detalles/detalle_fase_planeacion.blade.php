<div class="divider mailbox-divider"></div>
<div class="center center-align">
    <span class="mailbox-title primary-text">
        <i class="material-icons">attach_file</i>
        Evidencias de la fase de planeación.
    </span>
</div>
<div class="divider mailbox-divider"></div>
<div class="row">
    <div class="col s6 m6 l6">
        <p class="p-v-xs">
            <input type="checkbox" disabled {{ $proyecto->cronograma == 1 ? 'checked' : '' }}
                id="txtcronograma" name="txtcronograma" value="1">
            <label for="txtcronograma">
                Cronograma de trabajo.
            </label>
        </p>
    </div>
    <div class="col s6 m6 l6">
        <p class="p-v-xs">
            <input type="checkbox" disabled {{ $proyecto->estado_arte == 1 ? 'checked' : '' }} id="txtestado_arte" name="txtestado_arte" value="1">
            <label for="txtestado_arte">Estado del arte y/o Canvas</label>
        </p>
    </div>
</div>
<div class="row">
    @include('proyectos.archivos_table_fase', ['fase' => 'planeacion'])
</div>
