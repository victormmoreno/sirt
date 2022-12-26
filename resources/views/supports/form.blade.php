<form enctype="multipart/form-data"  class="m-t-md" action="{{ route('support.store')}}" id="formSupport" method="POST">
    {!! csrf_field() !!}
    <div class="row">
        <div class="input-field col s12">
            <select name="cmbsolicitud">
                <option value="" disabled selected>Seleccione una opción</option>
                <option value="Incidencia">Incidencia</option>
                <option value="Requerimiento">Requerimiento</option>
            </select>
            <label>Tipo Solicitud<span class="red-text">*</span></label>
            <small id="cmbsolicitud-error" class="error red-text"></small>
        </div>
        <div class="input-field col s12">
            <input id="txtasunto" type="text" name="txtasunto" class="validate">
            <label for="txtasunto">Asunto<span class="red-text">*</span></label>
            <small id="txtasunto-error" class="error red-text"></small>
        </div>
        <div class="input-field col s12">
            <input id="txtemail" type="email" name="txtemail" value="{{$user->email}}" class="validate">
            <label for="email">Correo Electónico<span class="red-text">*</span></label>
            <small id="txtemail-error" class="error red-text"></small>
        </div>
        <div class="input-field col s12">
            <textarea id="message" name="txtmensaje" class="materialize-textarea"></textarea>
            <label for="message">Mensaje<span class="red-text">*</span></label>
            <small id="txtmensaje-error" class="error red-text"></small>
        </div>
    </div>
    <div>
        <div class="file-field input-field">
            <div class="btn bg-primary">
                <span>Archivo</span>
                <input type="file" name="filedocument">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Sube un documento PDF (Opcional)">
                <small id="filedocument-error" class="error red-text"></small>
            </div>
        </div>
    </div>
    <div class="row">
        <button type="submit" class="waves-effect waves-light btn bg-secondary m-b-xs right">Enviar</button>
    </div>
</form>
