{!! csrf_field() !!}
<div class="row">
    <div class="input-field col s12 m6 l6">
        <input id="txtdocumento_rep" name="txtdocumento_rep" value="" type="text" required>
        <label for="txtdocumento_rep">Documento del representante legal de la empresa</label>
    </div>
    <div class="input-field col s12 m6 l6">
        <input id="txtnombre_rep" name="txtnombre_rep" value="" type="text" required>
        <label for="txtnombre_rep">Nombre del representante legal de la empresa</label>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m6 l6">
        <select style="width: 100%" class="js-states" id="txtdesempenho" name="txtdesempenho" required>
            <option value="">Seleccione como fue el desempeño de la asesoría</option>
            <option value="Buena">Buena</option>
            <option value="Deficiente">Deficiente</option>
            <option value="Excelente">Excelente</option>
        </select>
    </div>
    <div class="input-field col s12 m6 l6">
        <select style="width: 100%" class="js-states" id="txtentidad_id" name="txtentidad_id" required>
            <option value="">Seleccione una empresa/grupo propietaria</option>
            @forelse ($proyecto->sedes as $key => $value)
            <option value="{{$value->empresa->id}},empresa">{{$value->empresa->nit}} - {{$value->empresa->nombre}}</option>
            @empty
            <option value="">No hay información disponible</option>
            @endforelse
            @forelse ($proyecto->gruposinvestigacion as $key => $value)
            <option value="{{$value->id}},grupo">{{$value->codigo_grupo}} - {{$value->entidad->nombre}}</option>
            @empty
            <option value="">No hay información disponible</option>
            @endforelse
        </select>
    </div>
</div>
<div class="divider"></div>
<center>
    <button type="submit" target="_blank" class="waves-effect cyan darken-1 btn center-aling">
        <i class="material-icons right">file_download</i>
        Generar carta
    </button>
    <a href="{{route('proyecto')}}" class="waves-effect red lighten-2 btn center-aling">
        <i class="material-icons right">backspace</i>Volver
    </a>
</center>