{!! csrf_field() !!}
@php
    $disabled = $articulacion->articulacion_proyecto->actividad->aprobacion_dinamizador == 1 ? 'disabled' : '';
@endphp
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<div class="row">
    <div class="input-field col s12 m4 l4">
        <input disabled id="txtgestor" name="txtgestor"
            value="{{ auth()->user()->nombres }} {{ auth()->user()->apellidos }}" type="text">
        <label for="txtgestor" class="">Gestor</label>
    </div>
    <div class="input-field col s12 m4 l4">
        <input disabled id="txtlinea" name="txtlinea" value="{{ $articulacion->articulacion_proyecto->actividad->gestor->lineatecnologica->nombre }}"
            type="text">
        <label for="txtlinea" class="">Línea Tecnológica</label>
    </div>
    <div class="input-field col s12 m4 l4">
        <input disabled id="txtcosto" name="txtcosto" value="$ {{$costo->getData()->costosTotales}}" type="text">
        <label for="txtcosto" class="">Costo apróximado de la articulación</label>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <div class="col s12 m6 l6 offset-l3 offset-m3">
        <h5 class="center">Productos alcanzados.</h5>
        @foreach ($articulacion->productos as $item)
        <p class="p-v-xs">
            <input {{$disabled}} type="checkbox" name="txtproducto_alcanzado[]" id="txtproducto{{$item->id}}" value="{{$item->id}}" {{$item->pivot->logrado == 1 ? 'checked' : ''}} >
            <label for="txtproducto{{$item->id}}">{{ $item->nombre }}</label>
        </p>
        @endforeach
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <h5 class="center">Conclusiones y siguientes investigaciones de la articulación.</h5>
</div>
<div class="row">
    <div class="col s12 m6 l6">
        <h5 class="center">Conclusiones.</h5>
        <div class="input-field col s12 m12 l12">
            <textarea {{$disabled}} name="txtconclusiones" class="materialize-textarea" length="1000" maxlength="1000" id="txtconclusiones">{{ $btnText == 'Guardar' ? '' : $articulacion->articulacion_proyecto->actividad->conclusiones }}</textarea>
            <label for="txtconclusiones">Conclusiones de la articulación <span class="red-text">*</span></label>
            <small id="txtconclusiones-error" class="error red-text"></small>
        </div>
    </div>
    <div class="col s12 m6 l6">
        <h5 class="center">Siguiente paso.</h5>
        <div class="input-field col s12 m12 l12">
            <textarea {{$disabled}} name="txtsiguientes_investigaciones" class="materialize-textarea" length="1000" maxlength="1000" id="txtsiguientes_investigaciones">{{ $btnText == 'Guardar' ? '' : $articulacion->siguientes_investigaciones }}</textarea>
            <label for="txtsiguientes_investigaciones">Siguientes investigaciones o proyectos de la articulación <span class="red-text">*</span></label>
            <small id="txtsiguientes_investigaciones-error" class="error red-text"></small>
        </div>
    </div>
</div>
@if ($articulacion->articulacion_proyecto->actividad->aprobacion_dinamizador == 1)
<div class="divider"></div>
<div class="row">
    <h5 class="center">Cierre de la articulación</h5>
</div>
<div class="row">
    <div class="card-panel green lighten-4 col s12 m6 l6 offset-m3 offset-l3">
        <div class="input-field col s12 m12 l12">
            <input {{$articulacion->fase->nombre == 'Cierre' ? 'disabled' : ''}} type="text" name="txtfecha_cierre" id="txtfecha_cierre" value="{{ \Carbon\Carbon::now()->toDateString() }}" class="datepicker picker__input">
            <label for="txtfecha_cierre">Fecha de Cierre <span class="red-text">*</span></label>
            <small id="txtfecha_cierre-error" class="error red-text"></small>
          </div>
    </div>
</div>
@endif
<div class="divider"></div>
<center>
    @if ($articulacion->fase->nombre != 'Cierre')
    <button type="submit" class="waves-effect cyan darken-1 btn center-aling">
        <i class="material-icons right">{{ isset($btnText) ? $btnText == 'Modificar' ? 'done' : 'done_all' : '' }}</i>
        @if ($articulacion->articulacion_proyecto->actividad->aprobacion_dinamizador == 1)
        Cerrar Articulación
        @else
        {{isset($btnText) ? $btnText : 'error'}}
        @endif
    </button>
    @endif
    <a href="{{route('articulacion.ejecucion', $articulacion->id)}}" class="waves-effect red lighten-2 btn center-aling">
        <i class="material-icons right">backspace</i>Cancelar
    </a>
</center>