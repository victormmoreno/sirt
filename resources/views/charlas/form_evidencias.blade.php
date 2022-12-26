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
      @if ( \Session::get('login_role') == App\User::IsInfocenter() || \Session::get('login_role') == App\User::IsArticulador() )
        <input type="checkbox" name="txtprogramacion" {{ $charla->programacion == 'No' ? '' : 'checked' }}  id="txtprogramacion" value="1">
        @else
        <input type="checkbox" name="txtprogramacion" {{ $charla->programacion == 'No' ? '' : 'checked' }} disabled  id="txtprogramacion" value="1">
      @endif
      <label for="txtprogramacion">Programación de la Charla (Pantallazo del Envío de Correos) <span class="red-text">*</span></label>
    </p>
  </div>
  <div class="col s4 m4 l4">
    <p class="p-v-xs">
      @if ( \Session::get('login_role') == App\User::IsInfocenter() || \Session::get('login_role') == App\User::IsArticulador() )
        <input type="checkbox" name="txtevidencia_fotografica" {{ $charla->evidencia_fotografica == 'No' ? '' : 'checked' }} id="txtevidencia_fotografica" value="1">
      @else
        <input type="checkbox" name="txtevidencia_fotografica" {{ $charla->evidencia_fotografica == 'No' ? '' : 'checked' }} disabled id="txtevidencia_fotografica" value="1">
      @endif
      <label for="txtevidencia_fotografica">Evidencias Fotográficas <span class="red-text">*</span></label>
    </p>
  </div>
  <div class="col s4 m4 l4">
    <p class="p-v-xs">
      @if (\Session::get('login_role') == App\User::IsInfocenter() || \Session::get('login_role') == App\User::IsArticulador())
        <input type="checkbox" name="txtlistado_asistentes" {{ $charla->listado_asistentes == 'No' ? '' : 'checked' }} id="txtlistado_asistentes" value="1">
      @else
        <input type="checkbox" name="txtlistado_asistentes" {{ $charla->listado_asistentes == 'No' ? '' : 'checked' }} disabled id="txtlistado_asistentes" value="1">
      @endif
      <label for="txtlistado_asistentes">Listado de Asistentes <span class="red-text">*</span></label>
    </p>
  </div>
</div>
@if ( \Session::get('login_role') == App\User::IsInfocenter() || \Session::get('login_role') == App\User::IsArticulador() )
  <div class="row">
    <ul class="collapsible" data-collapsible="accordion">
      <li>
        <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para subir los entregables de la Charla Informativa</div>
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
@endif
<div class="divider"></div>
