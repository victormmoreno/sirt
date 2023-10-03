{!! csrf_field() !!}
<div class="row">
    <div class="col s12 m12 l12">
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
    <a href="{{route('download.metas')}}" class="waves-effect waves-grey bg-secondary-lighten white-text btn">Descargar formato de metas</a>
    <button type="submit" class="waves-effect bg-secondary btn center-aling">
        <i class="material-icons right">send</i>
        Importar metas
    </button>
</center>
