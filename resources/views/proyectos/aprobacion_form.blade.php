{!! method_field('PUT')!!}
{!! csrf_field() !!}
<div class="row">
  <div class="col s12 m8 l8 offset-l2">
    <h4 class="center red-text">
      <i class="left medium material-icons">warning</i>
      Importante!
      <i class="right medium material-icons">warning</i>
    </h4>
  </div>
</div>
<div class="row">
  <ul class="collection">
    <li class="collection-item">
      <h5 class="center">¿Que sucede si no apruebo el proyecto?</h5>
      <p class="flow-text">
        Se debe tener en cuenta que para iniciar un proyecto, el dinamizador del nodo, el gestor y el talento líder del proyecto, deben realizar esta tarea (aprobar o no aprobar el proyecto),
        en caso de que uno de los tres antes mencionados, no apruebe el proyecto, este será eliminado y no podrá iniciar el proceso de desarrollo y la idea de proyecto pasará al estado anterior.
        <br>
        Estas acciones se hará una vez TODOS guarden los cambios.
      </p>
    </li>
    <li class="collection-item">
      <h5 class="center">¿Se puede reversar mi decision de aprobar o no aprobar el proyecto?</h5>
      <p class="flow-text">
        <b>No</b>. En caso de aprobar o no aprobar el proyecto, esta decisión <b class="red-text">no podrá ser reversada</b> una vez se guarda la información, así que por favor, asegúrese de elegir correctamente su decisión.
      </p>
    </li>
    <li class="collection-item">
      <h5 class="center">¿Quiénes faltan por aprobar o no aprobar el proyecto?</h5>
      <div class="row">
        <div class="col s12 m6 l6">
          <table>
            <thead>
              <tr>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pivot as $value)
                <tr>
                  <td>{{ $value->usuario }}</td>
                  <td>{{ $value->name }}</td>
                  <td>
                    @if ( $value->aprobacion == 'Pendiente' )
                      <div class="card orange lighten-3">
                        <div class="card-content">
                          {{ $value->aprobacion }}
                        </div>
                      </div>
                    @elseif( $value->aprobacion == 'No Aprobado' )
                      <div class="card red lighten-3">
                        <div class="card-content">
                          {{ $value->aprobacion }}
                        </div>
                      </div>
                    @else
                      <div class="card green lighten-3">
                        <div class="card-content">
                          {{ $value->aprobacion }}
                        </div>
                      </div>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="col s12 m6 l6">
          <blockquote>
            Recuerde que si el dinamizador, gestor o talento líder no aprueban el proyecto, este se eliminará una vez que todo han guardado los cambios.
          </blockquote>
        </div>
      </div>
    </li>
  </ul>
</div>
<h5 class="center">Datos de la Idea de Proyecto.</h5>
<div class="divider"></div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <input type="text" name="txtidea_codigo" id="txtidea_codigo" disabled value="{{ $proyecto->idea->codigo_idea }}">
    <label for="txtidea_codigo">Código de la Idea de Proyecto</label>
  </div>
  <div class="input-field col s12 m6 l6">
    <input type="text" name="txtidea_nombre" id="txtidea_nombre" disabled value="{{ $proyecto->idea->nombre_proyecto }}">
    <label for="txtidea_nombre">Nombre de la Idea de Proyecto</label>
  </div>
</div>
<h5 class="center">Datos del Proyecto de Base Tecnológica.</h5>
<div class="divider"></div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <input disabled type="text" name="txtnombre_proyecto" id="txtnombre_proyecto" value="{{ $proyecto->articulacion_proyecto->actividad->nombre }}">
    <label for="txtidea_nombre">Nombre del Proyecto</label>
  </div>
  <div class="input-field col s12 m6 l6">
    <input disabled type="text" name="txtgestor" id="txtgestor" value="{{ $proyecto->articulacion_proyecto->actividad->gestor->user->nombres }} {{ $proyecto->articulacion_proyecto->actividad->gestor->user->apellidos }}">
    <label for="txtgestor">Gestor a cargo del proyecto</label>
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <input disabled type="text" name="txttipo_articulacion" id="txttipo_articulacion" value="{{ $proyecto->tipoproyecto->nombre }}">
    <label for="txttipo_articulacion">Tipo de Proyecto</label>
  </div>
  <div class="input-field col s12 m6 l6">
    <input disabled type="text" name="txtarea_conocimiento" id="txtarea_conocimiento" value="{{ $proyecto->areaconocimiento->nombre }}">
    <label for="txtarea_conocimiento">Área de Conocimiento</label>
  </div>
</div>
<h5 class="center">Talentos que participan.</h5>
<div class="row">
  <div class="col s12 m6 l6 offset-m3 offset-l3">
    <table>
      <thead>
        <tr>
          <th>Talento</th>
          <th>Rol</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($proyecto->articulacion_proyecto->talentos as $value)
          <tr>
            <td>{{ $value->user->documento }} - {{ $value->user->nombres }} {{ $value->user->apellidos }}</td>
            <td>{{ $value->pivot->talento_lider == 1 ? 'Talento Líder' : 'Autor' }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<div class="divider"></div>
<div class="row">
  <h4 class="center">¿Aprueba o no aprueba?</h4>
  <div class="col s12 m6 l6">
    <p class="p-v-xs">
      <input name="txtaprobacion" {{ $aprobado->aprobacion_value != 0 ? 'disabled' : '' }} {{ $aprobado->aprobacion_value == 1 ? 'checked' : '' }} class="with-gap" value="1" type="radio" id="txtaprobacion" >
      <label for="txtaprobacion">Aprobar</label>
    </p>
  </div>
  <div class="col s12 m6 l6">
    <p class="p-v-xs">
      <input name="txtaprobacion"  {{ $aprobado->aprobacion_value != 0 ? 'disabled' : '' }} {{ $aprobado->aprobacion_value == 2 ? 'checked' : '' }} class="with-gap" value="2" type="radio" id="txtnoaprobacion" >
      <label for="txtnoaprobacion">No Aprobar</label>
    </p>
  </div>
</div>
<div class="divider"></div>
<center>
  @if ( $aprobado->aprobacion_value == 0 )
    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Guardar</button>
  @endif
  <a href="{{ route('proyecto') }}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
</center>
