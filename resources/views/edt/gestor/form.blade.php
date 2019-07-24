{!! csrf_field() !!}
<div class="card red lighten-3">
  <div class="row">
    <div class="col s12 m12">
      <div class="card-content white-text">
        <p><i class="material-icons left"> info_outline</i>  Los datos marcados con * son obligatorios</p>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <i class="material-icons prefix">date_range</i>
    <input id="txtfecha_inicio" type="text" name="txtfecha_inicio" class="datepicker" value="{{ isset($edt) ? $edt->fecha_inicio : '' }}">
    <label for="txtfecha_inicio">Fecha de Inicio <span class="red-text">*</span></label>
    <small id="txtfecha_inicio-error" class="error red-text"></small>
  </div>
  <div class="input-field col s12 m6 l6">
    <i class="material-icons prefix">account_balance_wallet</i>
    <input id="txtnombre" type="text" name="txtnombre" value="{{ isset($edt) ? $edt->nombre : '' }}">
    <label for="txtnombre">Nombre <span class="red-text">*</span></label>
    <small id="txtnombre-error" class="error red-text"></small>
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m6 l6">
    <i class="material-icons prefix">language</i>
    <select class="js-states" id="txtareaconocimiento_id" name="txtareaconocimiento_id" style="width: 100%">
      <option value="">Seleccione el Área de Conocmiento</option>
      @forelse ($areasconocimiento as $id => $value)
        <option value="{{$id}}">{{$value}}</option>
      @empty
        <option value="">No hay información disponible</option>
      @endforelse
    </select>
    <label for="txtareaconocimiento_id">Área de Conocmiento <span class="red-text">*</span></label>
    <small id="txtareaconocimiento_id-error" class="error red-text"></small>
  </div>
  <div class="input-field col s12 m6 l6">
    <i class="material-icons prefix">filter_list</i>
    <select class="js-states" id="txttipo_edt" name="txttipo_edt" style="width: 100%">
      <option value="">Seleccione el tipo de EDT</option>
      @foreach ($tiposedt as $key => $value)
        <option value="{{$value->id}}">{{$value->nombre}}</option>
      @endforeach
    </select>
    <label for="txttipo_edt">Seleccione el tipo de EDT <span class="red-text">*</span></label>
    <small id="txttipo_edt-error" class="error red-text"></small>
  </div>
</div>
<div class="row">
  <div class="col s12 m2 l2">
    <blockquote>
      <ul class="collection">
        <li class="collection-item">Para asociar una empresa a la EDT debes buscarla en la tabla de la izquierda y presionar en el botón con el ícono <i class="material-icons">done_all</i> de dicha empresa.</li>
        <li class="collection-item">Las empresas que se registrarán en la edt se mostrarán en la tabla derecha (color verde), para removerlas de la edt se debe presionar el botón con el ícono <i class="material-icons">delete_sweep</i> de dicha empresa.</li>
      </ul>
    </blockquote>
  </div>
  <div class="col s12 m5 l5">
    <div class="card-panel orange lighten-5">
      <table style="width: 100%" id="empresasDeTecnoparque_modEdt_table" class="display responsive-table datatable-example dataTable">
        <thead>
          <tr>
            <th>Nit</th>
            <th>Nombre de la Empresa</th>
            <th>Asociar a EDT</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <div class="col s12 m5 l5">
    <div class="card-panel green accent-1">
      <table style="width: 100%" id="detalleEntidadesAsociadasAEdt" class="display responsive-table datatable-example dataTable">
        <thead>
          <tr>
            <th>Nit</th>
            <th>Nombre de la Empresa</th>
            <th>Eliminar</th>
          </tr>
        </thead>
        <tbody>
          @if (isset($entidadesAsociadasALaEdt))
            @foreach ($entidadesAsociadasALaEdt as $key => $value)

            @endforeach
          @endif
        </tbody>
      </table>
      <small id="entidades-error" class="error red-text"></small>
    </div>
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m12 l12 ">
    <i class="material-icons prefix">mode_edit</i>
    <textarea id="txtobservaciones" class="materialize-textarea" length="1000" name="txtobservaciones">{{ isset($edt) ? $edt->observaciones : '' }}</textarea>
    <label for="txtobservaciones">Observaciones</label>
    <small id="txtobservaciones-error" class="error red-text"></small>
  </div>
</div>
<br>
<h5 class="center-align">Asistentes</h5>
<div class="divider"></div>
<br>
<div class="row">
  <div class="input-field col s12 m3 l3 ">
    <i class="material-icons prefix">supervisor_account</i>
    <input id="txtempleados" type="number" class="validate" name="txtempleados" value="{{ isset($edt) ? $edt->empleados : '0' }}">
    <label for="txtempleados">Empleados <span class="red-text">*</span></label>
    <small id="txtempleados-error" class="error red-text"></small>
  </div>
  <div class="input-field col s12 m3 l3 ">
    <i class="material-icons prefix">portrait</i>
    <input id="txtinstructores" type="number" class="validate" name="txtinstructores" value="{{ isset($edt) ? $edt->instructores : '0' }}">
    <label for="txtinstructores">Instructores <span class="red-text">*</span></label>
    <small id="txtinstructores-error" class="error red-text"></small>
  </div>
  <div class="input-field col s12 m3 l3 ">
    <i class="material-icons prefix">school</i>
    <input id="txtaprendices" type="number" class="validate" name="txtaprendices" value="{{ isset($edt) ? $edt->aprendices : '0' }}">
    <label for="txtaprendices">Aprendices <span class="red-text">*</span></label>
    <small id="txtaprendices-error" class="error red-text"></small>
  </div>
  <div class="input-field col s12 m3 l3 ">
    <i class="material-icons prefix">person</i>
    <input id="txtpublico" type="number" class="validate" name="txtpublico" value="{{ isset($edt) ? $edt->publico : '0' }}">
    <label for="txtpublico">Público <span class="red-text">*</span></label>
    <small id="txtpublico-error" class="error red-text"></small>
  </div>
</div>
<br>
<center>
  <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">{{ isset($btnText) ? 'done' : 'done_all'}}</i>{{isset($btnText) ? $btnText : 'error'}}</button>
  <a href="{{route('edt')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
</center>
