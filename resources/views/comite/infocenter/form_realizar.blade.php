{!! csrf_field() !!}
@if($errors->any())
<div class="card red lighten-3">
    <div class="row">
        <div class="col s12 m12">
            <div class="card-content white-text">
                <p>
                    <i class="material-icons left"> info_outline</i> Los datos marcados con * son obligatorios
                </p>
            </div>
        </div>
    </div>
</div>
@endif
<center>
    <span class="card-title center-align">Datos del Comité</span> <i
        class="Small material-icons prefix">account_circle </i>
</center>
<div class="divider"></div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">location_city</i>
        <input id="txtnombrenodo" type="text" value="{{ \NodoHelper::returnNameNodoUsuario() }}" name="txtnombrenodo" disabled>
        <label for="txtnombrenodo">Nodo <span class="red-text">*</span></label>
    </div>
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">date_range</i>
        <input id="txtfechacomite_create" disabled type="text" name="txtfechacomite_create" class="datepicker" value="{{$comite->fechacomite->isoFormat('YYYY-MM-DD')}}">
        <label for="txtfechacomite_create" class="active">Fecha del Comité <span class="red-text">*</span></label>
    </div>
</div>
<div class="divider"></div>
<h5 class="center">Observaciones del comité</h5>
<div class="input-field col s12 m12 l12">
    <i class="material-icons prefix">speaker_notes</i>
    <textarea name="txtobservacionescomite" class="materialize-textarea" length="1000" maxlength="1000" id="txtobservacionescomite">{{$comite->observaciones}}</textarea>
    <label for="txtobservacionescomite">Observaciones del Comité</label>
</div>
<div class="divider"></div>
<center>
    <span class="card-title center-align">Ideas de Proyecto</span>
    <i class="Small material-icons prefix">info</i>
</center>
<div class="row">
    <div class="col s12 m12 l12">
        <div class="card-content">
            <table class="responsive-table striped" style="width: 100%">
                <thead>
                    <tr>
                        <th style="width: 20%">Idea de Proyecto</th>
                        <th style="width: 10%">¿Asistió?</th>
                        <th style="width: 10%">¿Admitido?</th>
                        <th style="width: 20%"><a class="modal-trigger" href="#modalEstados"><i class="material-icons left">help</i></a>Próximo estado de la idea</th>
                        <th style="width: 40%">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comite->ideas as $key => $value)
                        <tr id="ideaAsociadaAgendamiento{{$value->id}}">
                            <td><input type="hidden" name="ideas[]" value="{{$value->id}}">{{$value->codigo_idea}} - {{$value->nombre_proyecto}}</td>
                            <td>
                                <div class="switch m-b-md">
                                    <label>
                                      No
                                      <input type="checkbox" name="txtasistido[]" id="txtasistido{{$value->id}}" {{$value->pivot->asistencia == 1 ? 'checked' : ''}} value="{{$value->id}}">
                                      <span class="lever"></span>
                                      Si
                                    </label>
                                </div>    
                            </td>
                            <td>
                                <div class="switch m-b-md">
                                    <label>
                                      No
                                      <input type="checkbox" name="txtadmitidos[]" id="txtadmitidos{{$value->id}}" {{$value->pivot->admitido == 1 ? 'checked' : ''}} value="{{$value->id}}" onclick="validarAdmitido({{$value->id}}, {{$estados->where('nombre', 'Admitido')->first()->id}}, '{{$estados->where('nombre', 'Admitido')->first()->nombre}}')">
                                      <span class="lever"></span>
                                      Si
                                    </label>
                                </div>    
                            </td>
                            <td>
                                <label for="txtestadoidea{{$value->id}}">Estado de la idea <span class="red-text">*</span></label>
                                <select id="txtestadoidea{{$value->id}}" class="js-states" style="width: 100%;" name="txtestadoidea[]" onchange="setEstadoIdeaProyecto({{$value->id}})">
                                    <option value="">Seleccione el estado de la idea de proyecto</option>
                                    @foreach ($estados as $key2 => $item)
                                        @if ($value->pivot->admitido == 1)
                                            @if ($item->nombre == 'Admitido')
                                            <option value="{{$item->nombre}}" selected>{{$item->nombre}}</option> 
                                            @endif
                                        @else
                                            @if ($item->nombre != 'Admitido')
                                            <option value="{{$item->nombre}}" {{ $value->estadoIdea->nombre == $item->nombre ? 'selected' : '' }}>{{$item->nombre}}</option> 
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                                <small id="txtestadoidea.{{$key}}-error" class="error red-text"></small>
                            </td>
                            <td>
                                <textarea name="txtobservacionesidea[]" class="materialize-textarea" length="2000" maxlength="2000" id="txtobservacionesidea{{$value->id}}">{{$value->pivot->observaciones}}</textarea>
                                <label for="txtobservacionesidea{{$value->id}}" id="labelobservacionesidea">Observaciones de la Idea de Proyecto</label>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <center>
        <button type="submit" class="btn waves-effect cyan darken-1 center-aling"><i class="material-icons right">{{ isset($btnText) ? $btnText == 'Modificar' ? 'done' : 'done_all' : '' }}</i>{{isset($btnText) ? $btnText : 'error'}}</button>
        <a href="{{route('csibt.detalle', $comite->id)}}" class="btn waves-effect red lighten-2  center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
    </center>
</div>
<div id="modalEstados" class="modal">
    <div class="modal-content">
      <h4>Próximo estado de la idea de proyecto</h4>
      <p>
          Este campo del formulario te permitirá asignar un estado a la idea de proyecto.
          <br>
          En caso de que la idea de proyecto se apruebe en el comité, automáticamente esta idea de proyecto tendrá un estado de "Admitido".
          <br>
          En caso de que la idea de proyecto no se apruebe en el comité, puedes elegir un estado de la idea de proyecto entre los siguientes: <b>Inhabilitado, Inicio o Reagendamiento</b>
          <br>
          ¿Qué significa cada uno de estos estados?
          <br>
          <ul class="collection">
              <li class="collection-item">
                <b>Inhabilitado:</b> La idea ya no se podrá registrar en un futuro entrenamiento/taller de fortalecimiento y/o comité.
              </li>
              <li class="collection-item">
                <b>Inicio:</b> La idea se puede registrar en un futuro entrenamiento/taller de fortalecimiento ó en otro comité.
              </li>
              <li class="collection-item">
                <b>Reagendamiento:</b> La idea de puede reagendar a un próximo comité pero ya no se podrá asociar a un entrenamiento/taller de fortalecimiento.
              </li>
          </ul>
      </p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Ok.</a>
    </div>
</div>