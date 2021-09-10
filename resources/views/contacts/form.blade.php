<form class="m-t-md" action="{{ route('contacts.store')}}" id="formContact" method="POST">
    {!! csrf_field() !!}
    <div class="row">
        <div class="input-field col s12">
            <select name="cmbsolicitud">
                <option value="" disabled selected>Seleccione una opción</option>
                <option value="Incidencia">Incidencia</option>
                <option value="Requerimiento">Requerimiento</option>
            </select>
            <label>Tipo Solicitud</label>
        </div>
        <div class="input-field col s12">
            <input id="txtasunto" type="text" name="txtasunto" class="validate">
            <label for="txtasunto">Asunto</label>
        </div>
        <div class="input-field col s12">
            <input id="email" type="email" name="txtemail" value="{{$user->email}}" class="validate">
            <label for="email">Correo Electónico</label>
        </div>
        <div class="input-field col s12">
            <textarea id="message" name="txtmensaje" class="materialize-textarea"></textarea>
            <label for="message">Mensaje</label>
        </div>
    </div>
    <div>
        <div class="file-field input-field">
            <div class="btn yellow darken-2">
                <span>Archivo</span>
                <input type="file" name="filedocument">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Sube un documento PDF (Opcional)">
            </div>
        </div>
    </div>
    <div class="row">
        <button type="submit" class="waves-effect waves-light btn orange m-b-xs right">Enviar</button>
    </div>
</form>
