<div class="row">
    <div class="input-field col s12 m6 l6">
        <input name="txtcodigo_entrenamiento" disabled value="{{ $entrenamiento->codigo_entrenamiento }}" id="txtcodigo_entrenamiento">
        <label class="active" for="txtcodigo_entrenamiento">Código del taller de fortalecimiento</label>
    </div>
    <div class="input-field col s12 m6 l6">
        <input name="txtnombre" value="{{ $entrenamiento->fecha_sesion1 }}" disabled id="txtnombre" required>
        <label class="active" for="txtnombre">Fecha del taller de fortalecimiento</label>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <div class="col s4 m4 l4">
      <p class="p-v-xs">
          @if ($entrenamiento->correos == 0)
          <input type="checkbox" name="txtcorreos" id="txtcorreos" value="1" disabled>
          @else
          <input type="checkbox" name="txtcorreos" checked id="txtcorreos" value="1" disabled>
          @endif
        <label for="txtcorreos">Correos</label>
      </p>
    </div>
    <div class="col s4 m4 l4">
      <p class="p-v-xs">
          @if ($entrenamiento->fotos == 0)
          <input type="checkbox" name="txtfotos" id="txtfotos" value="1" disabled>
          @else
          <input type="checkbox" name="txtfotos" checked id="txtfotos" value="1" disabled>
          @endif
        <label for="txtfotos">Fotos</label>
      </p>
    </div>
    <div class="col s4 m4 l4">
      <p class="p-v-xs">
          @if ($entrenamiento->listado_asistencia == 0)
          <input type="checkbox" name="txtlistado_asistencia" id="txtlistado_asistencia" value="1" disabled>
          @else
          <input type="checkbox" name="txtlistado_asistencia" checked id="txtlistado_asistencia" value="1" disabled>
          @endif
        <label for="txtlistado_asistencia">Listado de Asistencia</label>
      </p>
    </div>
</div>