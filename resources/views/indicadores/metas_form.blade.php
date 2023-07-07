{!! csrf_field() !!}
<div class="row">
    <div class="col s12 m6 l6">
        <div class="input-field file-field">
            <div class="btn">
                <span>File</span>
                <input type="file" name="nombreArchivo" accept=".xlsx">
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
            </div>
        </div>
    </div>
</div>
<center>
    <button type="submit" class="waves-effect cyan darken-1 btn center-aling">
        <i class="material-icons right">done</i>
        Importar metas
    </button>
</center>
