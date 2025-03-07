{!! csrf_field() !!}
@if ($errors->any())
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
    <span class="card-title center-align">Datos del Comité</span> <i class="Small material-icons prefix">account_circle
    </i>
</center>
<div class="divider"></div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">location_city</i>
        <input id="txtnombrenodo" type="text" value="{{ $comite->ideas()->first()->nodo->entidad->nombre }}"
            name="txtnombrenodo" disabled>
        <label for="txtnombrenodo">Nodo <span class="red-text">*</span></label>
    </div>
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">date_range</i>
        <input id="txtfechacomite_create" disabled type="text" name="txtfechacomite_create" class="datepicker"
            value="{{ $comite->fechacomite->isoFormat('YYYY-MM-DD') }}">
        <label for="txtfechacomite_create" class="active">Fecha del Comité <span class="red-text">*</span></label>
    </div>
</div>
<div class="divider"></div>
<h5 class="center">Observaciones del comité</h5>
<div class="input-field col s12 m12 l12">
    <i class="material-icons prefix">speaker_notes</i>
    <textarea name="txtobservacionescomite" disabled class="materialize-textarea" length="1000" maxlength="1000"
        id="txtobservacionescomite">{{ $comite->observaciones }}</textarea>
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
                        <th style="width: 20%">
                            Idea de Proyecto
                        </th>
                        <th style="width: 5%">
                            ¿Admitido?
                        </th>
                        <th style="width: 30%">
                            Oservaciones del comité
                        </th>
                        <th style="width: 25%">
                            <a class="modal-trigger" href="#modalGestores"><i
                                    class="material-icons left">help</i></a>Expertos a cargo de la idea
                        </th>
                        <th style="width: 20%">
                            <a class="modal-trigger" href="#modalDerivarIdea"><i
                                    class="material-icons left">help</i></a>Derivar idea de proyecto
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comite->ideas as $key => $value)
                        <tr id="ideaAsociadaAgendamiento{{ $value->id }}">
                            <td><input type="hidden" name="ideas[]"
                                    value="{{ $value->id }}">{{ $value->codigo_idea }} -
                                {{ $value->nombre_proyecto }}</td>
                            <td>
                                {{ $value->pivot->admitido == 1 ? 'Si' : 'No' }}
                            </td>
                            <td>{{ $value->pivot->observaciones }}</td>
                            <td>
                                <label for="txtgestor_id{{ $value->id }}">Experto a cargo <span
                                        class="red-text">*</span></label>
                                <select id="txtgestor_id{{ $value->id }}" class="js-states browser-default select2"
                                    style="width: 100%;" name="txtgestores[]">
                                    @if ($value->pivot->admitido == 1)
                                        <option value="">Seleccione el experto a cargo de la idea de proyecto</option>
                                        @foreach($gestores as $id => $gestor)
                                            <option value="{{$gestor->id}}">{{$gestor->nombres}} {{$gestor->apellidos}}</option>
                                        @endforeach
                                    @else
                                        <option value="-1">Esta idea de proyecto no fue admitida.</option>
                                    @endif
                                </select>
                                <small id="txtgestor_id.{{ $key }}-error" class="error red-text"></small>
                            </td>
                            <td>
                                @if ($value->pivot->admitido == 1)
                                <a href="javascript:void(0)" onclick="confirmacionDuplicidad( event, '{{route('idea.derivar', [$value->id, $comite->id, 2])}}' )">
                                    <div class="card-panel green lighten-3 black-text center">
                                        Duplicar idea de proyecto.
                                    </div>
                                </a>
                                @else
                                    <a href="javascript:void(0)">
                                        <div class="card-panel grey black-text center">
                                            Idea de proyecto no admitida.
                                        </div>
                                    </a>
                                @endif
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
        <button type="submit" class="waves-effect waves-light btn bg-secondary center-align"><i
                class="material-icons right">send</i>Guardar</button>
        <a href="{{ route('csibt.detalle', $comite->id) }}" class="waves-effect bg-danger btn center-align"><i
                class="material-icons left">backspace</i>Cancelar</a>
    </center>
</div>
<div id="modalGestores" class="modal">
    <div class="modal-content">
        <h4>Experto a cargo de la idea</h4>
        <p>
            Este campo del formulario te permitirá asignar un experto del nodo el cuál estará a cargo del proyecto.
            <br>
            Debes tener en cuenta que una vez se registre el proyecto, el dinamizador puede re-asignar un experto al
            proyecto.
        </p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Ok.</a>
    </div>
</div>
<div id="modalDerivarIdea" class="modal">
    <div class="modal-content">
        <h4>Derivar idea de proyecto</h4>
        <p>
            En caso de que en una idea de proyecto se va a realizar mas de un TRL, se presiona este botón para hacer una
            duplicación de la idea de proyecto
            con la intención de que se pueda asignar a mas de un experto.
        </p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Ok.</a>
    </div>
</div>
