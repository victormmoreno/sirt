<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
{!! method_field('PUT')!!}
{!! csrf_field() !!}
@php \Session::get('login_role') != App\User::IsExperto() ? $disabled = 'disabled' : $disabled = '' @endphp
<div class="row">
  <div class="input-field col s12 m6 l6">
    <input id="txtcodigo_actividad" disabled value="{{$articulacion->codigo_articulacion}}">
    <label class="active" for="txtcodigo_actividad">Código de la Intervención</label>
  </div>
  <div class="input-field col s12 m6 l6">
    <input value="{{$articulacion->fecha_inicio->toDateString()}}" id="txtfecha_inicio" disabled>
    <label class="active" for="txtfecha_inicio">Fecha de Inicio de la Intervención</label>
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <input id="txtestado" disabled value="{{$articulacion->estado}}">
    <label class="active" for="txtestado">Estado de la Intervención</label>
  </div>
  <div class="input-field col s12 m6 l6">
    <input id="txttipo_articulacion" value="{{$articulacion->tipoArticulacion}}" disabled>
    <label class="active" for="txttipo_articulacion">Actividad</label>
  </div>
</div>
<div class="divider"></div>
<div class="row">
  <h5>Entregables Fase de Inicio</h5>
  <div class="col s4 m4 l4">
    <p class="p-v-xs">
      <input type="checkbox" {{$disabled}} name="entregable_acta_inicio" {{ $articulacion->acta_inicio == 0 ? '' : 'checked' }} id="entregable_acta_inicio" value="1">
      <label for="entregable_acta_inicio">Acta de Inicio<span class="red-text">*</span></label>
      {!! $articulacion->tipo_articulacion == 'Grupo de Investigación' ? '<a class="btn btn-floating modal-trigger" href="#modalContenidoActaInicio"><i class="material-icons left">info_outline</i></a>' : '' !!}
    </p>
  </div>
  @if ($articulacion->tipo_articulacion == 'Grupo de Investigación')
    <div class="col s4 m4 l4">
      <p class="p-v-xs">
        <input type="checkbox" {{ $disabled }} name="entregable_acuerdo_confidencialidad_compromiso" {{ $articulacion->acc == 0 ? '' : 'checked' }} id="entregable_acuerdo_confidencialidad_compromiso" value="1">
        <label for="entregable_acuerdo_confidencialidad_compromiso">Formato de confidencialidad y compromiso firmado <span class="red-text">*</span></label>
      </p>
    </div>
  @endif
</div>
@if ($disabled == '')
  <div class="row">
    <ul class="collapsible" data-collapsible="accordion">
      <li>
        <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para subir los entregables de la fase de Inicio</div>
        <div class="collapsible-body">
          <div class="row">
            <div class="center col s12 m12 l12">
              <h6>Pulse aquí para subir los entregables de la fase de Inicio.</h6>
              <div class="dropzone" id="fase_inicio_articulacion"></div>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
@endif
<div class="divider"></div>
@if ($disabled == '')
  <div class="row">
    <ul class="collapsible" data-collapsible="accordion">
      <li>
        <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para subir los entregables de la fase de {{ $articulacion->tipo_articulacion == 'Grupo de Investigación' ? 'Co-Ejecución' : 'Ejecución' }}.</div>
        <div class="collapsible-body">
          <div class="row">
            <div class="center col s12 m12 l12">
              <h6>Pulse aquí para subir los entregables de la fase de {{ $articulacion->tipo_articulacion == 'Grupo de Investigación' ? 'Co-Ejecución' : 'Ejecución' }}.</h6>
              <div class="dropzone" id="fase_ejecucion_articulacion"></div>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
@endif
<div class="divider"></div>
<div class="row">
  <h5>Entregables de la Fase de Cierre</h5>
  <div class="col s4 m4 l4">
    <p class="p-v-xs">
      <input type="checkbox" {{ $disabled }} name="entregable_acta_cierre" {{ $articulacion->acta_cierre == 0 ? '' : 'checked' }} id="entregable_acta_cierre" value="1">
      <label for="entregable_acta_cierre">Acta de Cierre<span class="red-text">*</span></label>
    </p>
  </div>
  @if ($articulacion->tipo_articulacion == 'Empresa' || $articulacion->tipo_articulacion == 'Emprendedor')
    <div class="col s4 m4 l4">
      <p class="p-v-xs">
        <input type="checkbox" {{ $disabled }} name="entregable_informe_final" {{ $articulacion->informe_final == 0 ? '' : 'checked' }} id="entregable_informe_final" value="1">
        <label for="entregable_informe_final">Informe Final de la Asesoría<span class="red-text">*</span></label>
      </p>
    </div>
    <div class="col s4 m4 l4">
      <p class="p-v-xs">
        <input type="checkbox" {{ $disabled }} name="entregable_encuesta_satisfaccion" {{ $articulacion->pantallazo == 0 ? '' : 'checked' }} id="entregable_encuesta_satisfaccion" value="1">
        <label for="entregable_encuesta_satisfaccion">Encuesta de Satisfacción (Pantallazo)<span class="red-text">*</span></label>
      </p>
    </div>
  @endif
</div>
@if ($disabled == '')
  <div class="row">
    <ul class="collapsible" data-collapsible="accordion">
      <li>
        <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para subir los entregables de la fase de Cierre</div>
        <div class="collapsible-body">
          <div class="row">
            <div class="center col s12 m12 l12">
              <h6>Pulse aquí para subir los entregables de la fase de Cierre.</h6>
              <div class="dropzone" id="fase_cierre_articulacion"></div>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
@endif
<div class="divider"></div>

