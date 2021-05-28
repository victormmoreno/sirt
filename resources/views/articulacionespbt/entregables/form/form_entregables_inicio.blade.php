{!! method_field('PUT')!!}
{!! csrf_field() !!}

<div class="divider"></div>
<div class="row">
    <h5>Entregables Fase Inicio</h5>
    
    <div class="col s6 m6 l6">
        <p class="p-v-xs">
            <input type="checkbox" {{$actividad->articulacionpbt->present()->articulacionPbtNameFase()  != 'Inicio' ? 'disabled' : '' }} {{ $actividad->formulario_inicio == 1 ? 'checked' : '' }} id="txtformulario_inicio" name="txtformulario_inicio" value="1">
            <label for="txtformulario_inicio">Formulario de incio. (se puede generar desde la plataforma)</label>
        </p>
    </div>
</div>
@if ($actividad->articulacionpbt->present()->articulacionPbtNameFase()  == 'Inicio')
<div class="row">
    <div class="card-panel teal">
        <div class="dropzone" id="fase_inicio_articulacion"></div>
    </div>
</div>
@endif