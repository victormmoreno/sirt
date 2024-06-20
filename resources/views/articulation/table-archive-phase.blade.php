<table class="display responsive-table datatable-example dataTable {{$fase}}" style="width: 100%" id="archivesArticulations{{$fase}}">
    <thead class="bg-primary white-text">
    <tr>
        <th>Archivo</th>

        <th style="width: 10%">Descargar</th>
        @if(Route::currentRouteName() == 'articulations.show.phase' || Route::currentRouteName() == 'articulations.cancel')
            <th style="width: 10%">Eliminar</th>
        @endif
    </tr>
    </thead>
</table>

