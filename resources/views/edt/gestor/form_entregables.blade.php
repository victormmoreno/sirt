<div class="row">
  <div class="input-field col s12 m12 l12">
    <input id="txtnombre" disabled value="{{$edt->nombre}}">
    <label for="txtnombre" class="active">Nombre de la Edt</label>
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <input type="text" id="txtcodigo_edt" disabled value="{{$edt->codigo_edt}}">
    <label for="txtcodigo_edt" class="active">Código de la Edt</label>
  </div>
  <div class="input-field col s12 m6 l6">
    <input type="text" id="txtgestor_id" disabled value="{{$edt->gestor}}">
    <label for="txtgestor_id" class="active">Experto</label>
  </div>
</div>
<div class="divider"></div>
<div class="row">
  <div class="col s4 m4 l4">
    <p class="p-v-xs">
      <input type="checkbox" name="txtfotografias" {{ $edt->fotografias == 'No' ? '' : 'checked' }} {{ \Session::get('login_role') != App\User::IsGestor() ? 'disabled' : '' }} id="txtfotografias" value="1">
      <label for="txtfotografias">Fotografias</label>
    </p>
  </div>
  <div class="col s4 m4 l4">
    <p class="p-v-xs">
      <input type="checkbox" name="txtlistado_asistencia" {{ $edt->listado_asistencia == 'No' ? '' : 'checked' }} {{ \Session::get('login_role') != App\User::IsGestor() ? 'disabled' : '' }} id="txtlistado_asistencia" value="1">
      <label for="txtlistado_asistencia">Listado de Asistencia</label>
    </p>
  </div>
  <div class="col s4 m4 l4">
    <p class="p-v-xs">
      <input type="checkbox" name="txtinforme_final" {{ $edt->informe_final == 'No' ? '' : 'checked' }} {{ \Session::get('login_role') != App\User::IsGestor() ? 'disabled' : '' }} id="txtinforme_final" value="1">
      <label for="txtinforme_final">Informe Final</label>
    </p>
  </div>
</div>
@if ( \Session::get('login_role') == App\User::IsGestor() )
  <div class="row">
    <ul class="collapsible" data-collapsible="accordion">
      <li>
        <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para subir los entregables de la Edt</div>
        <div class="collapsible-body">
          <div class="row">
            <div class="center col s12 m12 l12">
              <h6>Pulse aquí para subir los entregables del Entrenamiento.</h6>
              <div class="dropzone" id="evidencias_edt"></div>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
@endif
<div class="divider"></div>
