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
                  <td>{{ $value->aprobacion }}</td>
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
<h5 class="center">Datos de la Idea de Proyecto</h5>
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
<div class="row">
  <h4 class="center">¿Aprueba o no aprueba?</h4>
  <div class="col s12 m6 l6">
    <p class="p-v-xs">
      <input name="txtaprobacion" class="with-gap" value="1" type="radio" id="txtaprobacion">
      <label for="txtaprobacion">Aprobar</label>
    </p>
  </div>
  <div class="col s12 m6 l6">
    <p class="p-v-xs">
      <input name="txtaprobacion" class="with-gap" value="2" type="radio" id="txtnoaprobacion">
      <label for="txtnoaprobacion">No Aprobar</label>
    </p>
  </div>
</div>
<div class="divider"></div>
