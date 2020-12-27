<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<table>
    <thead>
        <tr>
            <th >Nodo</th>
            <th >Linea Tecnológica</th>
            <th >Equipo</th>
            <th >Referencia</th>
            <th >Marca</th>
            <th >Costo Adquisición</th>
            <th >Vida Util (Años)</th>
            <th >Promedio Horas uso al año</th>
            <th >Año de compra</th>
            <th >Año fin depreciación</th>
            <th >Depreciación por año</th>
            <th >Estado</th>
        </tr>
    </thead>
    <tbody>
        @forelse($equipos as $equipo)
        <tr>
            <td>
                {{$equipo->present()->equipoNodo()}}
            </td>
            <td>
                {{$equipo->present()->equipoLinea()}}
            </td>
            <td>
                {{$equipo->present()->equipoNombre()}}
            </td>
            <td>
                {{$equipo->present()->equipoReferencia()}}
            </td>
            <td>
                {{$equipo->present()->equipoMarca()}}
            </td>
            <td>
                {{$equipo->present()->equipoCostoAdquisicion()}}
            </td>
            <td>
                {{$equipo->present()->equipoVidaUtil()}}
            </td>
            <td>
                {{$equipo->present()->equipoHorasUsoAnio()}}
            </td>
            <td>
                {{$equipo->present()->equipoAnioCompra()}}
            </td>
            <td>
                {{$equipo->present()->equipoAnioDepreciacion()}}
            </td>
            <td>
                {{$equipo->present()->equipoDepreciacionPorAnio()}}
            </td>
            <td>
                {{$equipo->present()->equipoState()}}
            </td>
        </tr>
        @empty
        <tr>
            <td>
                No hay información disponible
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
