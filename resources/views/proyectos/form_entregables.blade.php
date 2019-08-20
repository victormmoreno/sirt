{!! method_field('PUT')!!}
{!! csrf_field() !!}
{!! \Session::get('login_role') != App\User::IsGestor() ? $disabled = 'disabled' : $disabled = '' !!}
<div class="row">
  <div class="input-field col s12 m6 l6">
    <input name="txtcodigo_proyecto" disabled value="{{ $proyecto->codigo_proyecto }}" id="txtcodigo_proyecto">
    <label class="active" for="txtcodigo_proyecto">Código de Proyecto</label>
  </div>
  <div class="input-field col s12 m6 l6">
    <input name="txtnombre" value="{{ $proyecto->nombre }}" disabled id="txtnombre" required >
    <label class="active" for="txtnombre">Nombre del Proyecto</label>
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <input name="txtgestor_id" value="{{ $proyecto->nombre_gestor }}" disabled id="txtgestor_id">
    <label class="active" for="txtgestor_id">Gestor</label>
  </div>
  <div class="input-field col s12 m6 l6">
    <input name="txtlinea" id="txtlinea" value="{{ $proyecto->nombre_linea }}" disabled>
    <label class="active" for="txtlinea">Línea Tecnológica</label>
  </div>
</div>
<div class="divider"></div>
<div class="row">
  <h5>Entregables Fase Inicio</h5>
  <div class="col s6 m6 l6">
    <p class="p-v-xs">
      <input type="checkbox" {{ $disabled }} {{ $entregables->acc == 'Si' ? 'checked' : '' }} id="txtacc" name="txtacc" value="1">
      <label for="txtacc">Formato de confidencialidad y compromiso firmado.</label>
    </p>
  </div>
  <div class="col s6 m6 l6">
    <p class="p-v-xs">
      <input type="checkbox" {{ $disabled }} {{ $entregables->manual_uso_inf == 'Si' ? 'checked' : '' }} id="txtmanual_uso_inf" name="txtmanual_uso_inf" value="1">
      <label for="txtmanual_uso_inf">Manual de uso de Infraestructura.</label>
    </p>
  </div>
</div>
{{-- Inicio para subir entregables en la fase de inicio --}}
@if (\Session::get('login_role') == App\User::IsGestor())
  @if ( $proyecto->nombre_estadoproyecto != 'Cierre PF' && $proyecto->nombre_estadoproyecto != 'Cierre PMV' )
    <div class="row">
      <ul class="collapsible" data-collapsible="accordion">
        <li>
          <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para subir los entregables de la fase de Inicio.</div>
          <div class="collapsible-body">
            <div class="row">
              <div class="center col s12 m12 l12">
                <h6>Pulse aquí para subir los entregables de la fase de Inicio.</h6>
                <div class="dropzone" id="fase_inicio_proyecto"></div>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  @endif
@endif
{{-- Fin para subir entregables en la fase de inicio --}}
<div class="divider"></div>
<div class="row">
  <h5>Entregables Fase Planeación</h5>
  <div class="col s6 m6 l6">
    <p class="p-v-xs">
      <input type="checkbox" {{ $disabled }} {{ $entregables->acta_inicio == 'Si' ? 'checked' : ''}} id="txtacta_inicio" name="txtacta_inicio" value="1">
      <label for="txtacta_inicio">Acta de Inicio.</label>
    </p>
  </div>
  <div class="col s6 m6 l6">
    <p class="p-v-xs">
      <input type="checkbox" {{ $disabled }} {{ $entregables->estado_arte == 'Si' ? 'checked' : ''}} id="txtestado_arte" name="txtestado_arte" value="1">
      <label for="txtestado_arte">Estado del Arte.</label>
    </p>
  </div>
</div>
{{-- Inicio para subir entregables en la fase de planeacion --}}
@if (\Session::get('login_role') == App\User::IsGestor())
  @if ( $proyecto->nombre_estadoproyecto != 'Cierre PF' && $proyecto->nombre_estadoproyecto != 'Cierre PMV' )
    <div class="row">
      <ul class="collapsible" data-collapsible="accordion">
        <li>
          <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para subir los entregables de la fase de Planeación.</div>
          <div class="collapsible-body">
            <div class="row">
              <div class="center col s12 m12 l12">
                <h6>Pulse aquí para subir los entregables de la fase de Planeación.</h6>
                <div class="dropzone" id="fase_planeacion_proyecto"></div>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  @endif
@endif

{{-- Fin para subir entregables en la fase de planeacion --}}
<div class="divider"></div>
<div class="row">
  <h5>Entregables Fase de Ejecución</h5>
  <div class="col s6 m6 l6">
    <p class="p-v-xs">
      <input type="checkbox" {{ $disabled }} {{ $entregables->actas_seguimiento == 'Si' ? 'checked' : '' }} id="txtactas_seguimiento" name="txtactas_seguimiento" value="1">
      <label for="txtactas_seguimiento">Actas de Seguimiento.</label>
    </p>
  </div>
  <div class="col s6 m6 l6">
    <p class="p-v-xs">
      <input type="checkbox" {{ $disabled }} {{ $entregables->video_tutorial == 'Si' ? 'checked' : '' }} id="txtvideo_tutorial" name="txtvideo_tutorial" value="1" onclick="mostrarInputUrlVideo()">
      <label for="txtvideo_tutorial">Video Tutorial.</label>
    </p>
  </div>
</div>
<div class="row" id="divUrlVideoTutorial">
  <div class="input-field col s12 m12 l12">
    <input type="text" {{ $disabled }} name="txturl_videotutorial" id="txturl_videotutorial" value="{{ old('txturl_videotutorial', $entregables->url_videotutorial) }}" onchange="urlVideoTutorialChange(this.value);">
    <label for="txturl_videotutorial">Url del Video Turorial <span class="red-text">*</span></label>
    @error('txturl_videotutorial')
      <label id="txturl_videotutorial-error" class="error" for="txturl_videotutorial">{{ $message }}</label>
    @enderror
  </div>
</div>
{{-- Inicio para subir entregables en la fase de ejecucion --}}
@if (\Session::get('login_role') == App\User::IsGestor())
  @if ( $proyecto->nombre_estadoproyecto != 'Cierre PF' && $proyecto->nombre_estadoproyecto != 'Cierre PMV' )
    <div class="row">
      <ul class="collapsible" data-collapsible="accordion">
        <li>
          <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para subir los entregables de la fase de Ejecución.</div>
          <div class="collapsible-body">
            <div class="row">
              <div class="center col s12 m12 l12">
                <h6>Pulse aquí para subir los entregables de la fase de Ejecución.</h6>
                <div class="dropzone" id="fase_ejecucion_proyecto"></div>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  @endif
@endif

{{-- Fin para subir entregables en la fase de ejecucion --}}
<div class="divider"></div>
<div class="row">
  <h5>Entregables Fase de Cierre</h5>
  <div class="col s12 m4 l4">
    <p class="p-v-xs">
      <input type="checkbox" {{ $disabled }} {{ $entregables->ficha_caracterizacion == 'Si' ? 'checked' : '' }} id="txtficha_caracterizacion" name="txtficha_caracterizacion" value="1">
      <label for="txtficha_caracterizacion">Ficha de caracterización del prototipo.</label>
    </p>
  </div>
  <div class="col s12 m4 l4">
    <p class="p-v-xs">
      <input type="checkbox" {{ $disabled }} {{ $entregables->acta_cierre == 'Si' ? 'checked' : '' }} id="txtacta_cierre" name="txtacta_cierre" value="1">
      <label for="txtacta_cierre">Acta de Cierre.</label>
      <a class="btn btn-floating modal-trigger" href="#modalContenidoActaCierre_Proyecto"><i class="material-icons left">info_outline</i></a>
    </p>
  </div>
  <div class="col s12 m4 l4">
    <p class="p-v-xs">
      <input type="checkbox" {{ $disabled }} {{ $entregables->encuesta == 'Si' ? 'checked' : '' }} id="txtencuesta" name="txtencuesta" value="1">
      <label for="txtencuesta">Encuesta de Satisfacción del Servicio.</label>
    </p>
  </div>
</div>
{{-- Inicio para subir entregables en la fase de cierre --}}
@if (\Session::get('login_role') == App\User::IsGestor())
  @if ( $proyecto->nombre_estadoproyecto != 'Cierre PF' && $proyecto->nombre_estadoproyecto != 'Cierre PMV' )
    <div class="row">
      <ul class="collapsible" data-collapsible="accordion">
        <li>
          <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para subir los entregables de la fase de Cierre.</div>
          <div class="collapsible-body">
            <div class="row">
              <div class="center col s12 m12 l12">
                <h6>Pulse aquí para subir los entregables de la fase de Cierre.</h6>
                <div class="dropzone" id="fase_cierre_proyecto"></div>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  @endif
@endif
{{-- Fin para subir entregables en la fase de cierre --}}
<div class="divider"></div>
<div class="row">
  <h5>Revisado Final</h5>
  <div class="col s12 m4 l4">
    <p class="p-v-xs">
      <input {{ \Session::get('login_role') != App\User::IsDinamizador() ? 'disabled' : '' }} name="txtrevisado_final" {{ $proyecto->revisado_final == 'Por Evaluar' ? 'checked' : ''}} value="0" type="radio" id="txtrevisadoa">
      <label for="txtrevisadoa">Por evaluar</label>
    </p>
  </div>
  <div class="col s12 m4 l4">
    <p class="p-v-xs">
      <input {{ \Session::get('login_role') != App\User::IsDinamizador() ? 'disabled' : '' }} name="txtrevisado_final" {{ $proyecto->revisado_final == 'Aprobado' ? 'checked' : '' }} value="1" type="radio" id="txtrevisadob">
      <label for="txtrevisadob">Aprobado</label>
    </p>
  </div>
  <div class="col s12 m4 l4">
    <p class="p-v-xs">
      <input {{ \Session::get('login_role') != App\User::IsDinamizador() ? 'disabled' : '' }} name="txtrevisado_final" {{ $proyecto->revisado_final == 'No Aprobado' ? 'checked' : ''}} value="2" type="radio" id="txtrevisadoc">
      <label for="txtrevisadoc">No aprobado</label>
    </p>
  </div>
</div>
<div class="divider"></div>
