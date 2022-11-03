<table class="display responsive-table datatable-example dataTable {{$fase}}" style="width: 100%" id="archivesArticulations">
    <thead>
    <tr>
        <th>Archivo</th>
        <th style="width: 10%">Descargar</th>
        @if(Route::currentRouteName() == 'articulations.show.phase')
            <th style="width: 10%">Eliminar</th>
        @endif
    </tr>
    </thead>
</table>

