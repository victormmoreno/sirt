{!! method_field('PUT')!!}
{!! csrf_field() !!}

<div class="row">
    <div class="card-panel green lighten-4 col s12 m6 l6 offset-m3 offset-l3">
        <div class="input-field col s12 m12 l12">
            <input {{$articulacion->aprobacion_dinamizador_suspender == 0 ? 'disabled' : ''}} type="text" name="txtfecha_cierre" id="txtfecha_cierre" value="{{ \Carbon\Carbon::now()->toDateString() }}" class="datepicker picker__input">
            <label for="txtfecha_cierre">Fecha de Cierre <span class="red-text">*</span></label>
            <small id="txtfecha_cierre-error" class="error red-text"></small>
        </div>
    </div>
</div>
@if (!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsFinalizado()))
    @if ($articulacion->aprobacion_dinamizador_suspender == 0)
        <div class="row">
            <div class="card-panel teal">
                <div class="dropzone" id="fase_suspendido_articulacion"></div>
            </div>
        </div>
    @endif
@endif
<div class="divider"></div>
