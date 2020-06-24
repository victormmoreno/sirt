
{!! csrf_field() !!}
@php
    $existe = isset($comite) ? true : false;
@endphp
@if($errors->any())
<div class="card red lighten-3">
    <div class="row">
        <div class="col s12 m12">
            <div class="card-content white-text">
                <p><i class="material-icons left"> info_outline</i> Los datos marcados
                    con * son obligatorios</p>
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
        <input id="txtnombrenodo" type="text"
            value="{{ \NodoHelper::returnNameNodoUsuario() }}" name="txtnombrenodo"
            disabled>
        <label for="txtnombrenodo">Nodo <span class="red-text">*</span></label>
    </div>
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">date_range</i>
        <input id="txtfechacomite_create" type="text" name="txtfechacomite_create" class="datepicker" value="{{ $existe ? $comite->fechacomite->isoFormat('YYYY-MM-DD') : Carbon\Carbon::now()->toDateString()}}">
        <label for="txtfechacomite_create" class="active">Fecha del Comité <span class="red-text">*</span></label>
        <small id="txtfechacomite_create-error" class="error red-text"></small>
    </div>
</div>
<div class="divider"></div>
<center>
    <span class="card-title center-align">Ideas de Proyecto</span>
    <i class="Small material-icons prefix">info</i>
</center>
<div class="row">
    <div class="col s12 m12 l12">
        <div class="card-content">
            <h5>
                <span class="red-text text-darken-2">Para registrar las ideas en el
                    comité dar click en el botón <a
                        class="btn-floating waves-effect waves-light red"><i
                            class="material-icons">add</i></a></span>
            </h5>
            <p>Si desea agregar mas ideas de proyecto por favor seleccione..</p>
            <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header active blue-grey lighten-1">
                        <i class="material-icons">lightbulb</i>Seleccione las ideas de proyecto que se presentarán en el comité
                    </div>
                    <div class="collapsible-body">
                        <div class="card-content">
                            <div class="row">
                                <div class="input-field col s12 m6 l6">
                                    <select id="txtideaproyecto" class="js-states browser-default select2" style="width: 100%;" name="txtideaproyecto">
                                        <option value="0">Seleccione las ideas de proyecto que se presentarán en el comité</option>
                                        @foreach ($ideas as $key => $value)
                                        <option value="{{$value['id']}}">{{$value['nombre_idea']}}</option>
                                        @endforeach
                                    </select>
                                    <label for="#txtideaproyecto" class="active">Ideas de Proyecto <span class="red-text">*</span></label>
                                </div>
                                <div class="input-field col s12 m6 l6">
                                    <i class="material-icons prefix">access_time</i>
                                    <input id="txthoraidea" type="text" class="pickertime" name="txthoraidea">
                                    <label for="txthoraidea">Hora <span class="red-text">*</span></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m12 l12">
                                    <textarea name="txtdireccion" class="materialize-textarea" length="500" maxlength="500" id="txtdireccion"></textarea>
                                    <label for="txtdireccion">Dirección donde se realizará el comité <span class="red-text">*</span></label>
                                </div>
                            </div>
                            <center>
                                <a onclick="addIdeaComite()"
                                    class="indigo lighten-2 btn-large"
                                    data-position="bottom" data-delay="50"
                                    data-tooltip="Agregar la idea de proyecto seleccionada al comité"><i
                                        class="material-icons left">add</i>Agregar</a>
                            </center>
                            <div class="card-content">
                                <table class="responsive-table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%">Idea de Proyecto</th>
                                            <th style="width: 10%">Hora</th>
                                            <th style="width: 50%">Dirección</th>
                                            <th style="width: 10%">Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblIdeasComiteCreate">
                                        @if ($existe)
                                            @foreach ($comite->ideas as $key => $value)
                                                <tr class="selected" id="ideaAsociadaAgendamiento{{$value->id}}">
                                                    <td><input type="hidden" name="ideas[]" value="{{$value->id}}">{{$value->nombre_proyecto}}</td>
                                                    <td><input type="hidden" name="horas[]" value="{{$value->pivot->hora}}">{{$value->pivot->hora}}</td>
                                                    <td><input type="hidden" name="direcciones[]" value="{{$value->pivot->direccion}}">{{$value->pivot->direccion}}</td>
                                                    <td><a class="waves-effect red lighten-3 btn" onclick="eliminarIdeaDelAgendamiento('{{$value->id}}')"><i class="material-icons">delete_sweep</i></a></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <center>
        <button type="submit" class="btn waves-effect cyan darken-1 center-aling"><i
                class="material-icons right">{{ isset($btnText) ? $btnText == 'Modificar' ? 'done' : 'done_all' : '' }}</i>{{isset($btnText) ? $btnText : 'error'}}</button>
        <a href="{{route('csibt')}}"
            class="btn waves-effect red lighten-2  center-aling"><i
                class="material-icons right">backspace</i>Cancelar</a>
    </center>
</div>