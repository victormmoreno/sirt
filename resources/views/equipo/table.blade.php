@if(session()->has('login_role') && (session()->get('login_role') == App\User::IsActivador() || session()->get('login_role') == App\User::IsExperto()))
<table class="display responsive-table" id="equipo_data_table">
    <thead>
        <th width="15%">Linea Tecnológica</th>
        <th width="15%">Equipo</th>
        <th width="15%">Referencia</th>
        <th width="15%">Marca</th>
        <th width="15%">Costo Adquisición</th>
        <th width="15%">Vida Util (Años)</th>
        <th width="15%">Promedio Horas uso al año</th>
        <th width="15%">Año de compra</th>
        <th width="15%">Año fin depreciación</th>
        <th width="15%">Depreciación por año</th>
        <th width="15%">Estado</th>
    </thead>
</table>
@else
<table class="display responsive-table" id="equipo_actions_data_table" style="width: 100%">
    <thead>
        <th width="15%">Linea Tecnológica</th>
        <th width="15%">Equipo</th>
        <th width="15%">Referencia</th>
        <th width="15%">Marca</th>
        <th width="15%">Costo Adquisición</th>
        <th width="15%">Vida Util (Años)</th>
        <th width="15%">Estado</th>
        <th width="15%">Detalle</th>
        <th width="15%">Editar</th>
        <th width="15%">Cambiar estado</th>
        {{-- <th width="15%">Eliminar</th> --}}
    </thead>
</table>
@endif