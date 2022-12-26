<div class="row">
  <div class="input-field col s12 m12 l12">
    <input type="text" id="txtcodigo_charla" disabled value="{{$charla->codigo_charla}}">
    <label for="txtcodigo_charla" class="active">Código de la Charla Informativa</label>
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <input type="text" id="txtfecha" disabled value="{{$charla->fecha}}">
    <label for="txtfecha" class="active">Fecha de la Charla Informativa</label>
  </div>
  <div class="input-field col s12 m6 l6">
    <input type="text" id="txtencargado" disabled value="{{$charla->encargado}}">
    <label for="txtencargado" class="active">Encargado de la Charla Informativa</label>
  </div>
</div>
<div class="divider"></div>
<div class="row">
  <div class="col s4 m4 l4">
    <p class="p-v-xs">
      <input type="checkbox" name="txtprogramacion" {{ $charla->programacion == 'No' ? '' : 'checked' }} {{session()->get('login_role') == auth()->user()->IsDinamizador() ? 'disabled' : ''}}  id="txtprogramacion" value="1">
      <label for="txtprogramacion">Programación de la Charla (Pantallazo del Envío de Correos) <span class="red-text">*</span></label>
    </p>
  </div>
  <div class="col s4 m4 l4">
    <p class="p-v-xs">
      <input type="checkbox" name="txtevidencia_fotografica" {{ $charla->evidencia_fotografica == 'No' ? '' : 'checked' }} {{session()->get('login_role') == auth()->user()->IsDinamizador() ? 'disabled' : ''}} id="txtevidencia_fotografica" value="1">
      <label for="txtevidencia_fotografica">Evidencias Fotográficas <span class="red-text">*</span></label>
    </p>
  </div>
  <div class="col s4 m4 l4">
    <p class="p-v-xs">
      <input type="checkbox" name="txtlistado_asistentes" {{ $charla->listado_asistentes == 'No' ? '' : 'checked' }} {{session()->get('login_role') == auth()->user()->IsDinamizador() ? 'disabled' : ''}} id="txtlistado_asistentes" value="1">
      <label for="txtlistado_asistentes">Listado de Asistentes <span class="red-text">*</span></label>
    </p>
  </div>
</div>
@can('showDropzone', App\Models\CharlaInformativa::class)
  <div class="row">
    <ul class="collapsible" data-collapsible="accordion">
      <li>
        <div class="collapsible-header teal lighten-4 active"><i class="material-icons">filter_drama</i>Pulse aquí para subir los entregables de la Charla Informativa</div>
        <div class="collapsible-body">
          <div class="row">
            <div class="center col s12 m12 l12">
              <h6>Pulse aquí para subir los entregables de la Charla Informativa.</h6>
              <div class="dropzone" id="evidencias_charlaInformartiva"></div>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
@endcan
<div class="divider"></div>
