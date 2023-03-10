<table>
    <thead>
        <tr>
            <th>Nodo</th>
            <th>Linea Tecnológica</th>
            <th>Código del equipo</th>
            <th>Equipo</th>
            <th>Referencia</th>
            <th>Marca</th>
            <th>Costo Adquisición</th>
            <th>Vida Util (Años)</th>
            <th>Promedio Horas uso al año</th>
            <th>Año de compra</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @forelse($equipos as $equipo)
        <tr>
            <td>
                {{$equipo->nodo}}
            </td>
            <td>
                {{$equipo->linea}}
            </td>
            <td>
                {{$equipo->codigo}}
            </td>
            <td>
                {{$equipo->nombre}}
            </td>
            <td>
                {{$equipo->referencia}}
            </td>
            <td>
                {{$equipo->marca}}
            </td>
            <td>
                {{$equipo->costo_adquisicion}}
            </td>
            <td>
                {{$equipo->vida_util}}
            </td>
            <td>
                {{$equipo->horas_uso_anio}}
            </td>
            <td>
                {{$equipo->anio_compra}}
            </td>
            <td>
                {{$equipo->deleted_at == null ? 'Habilitado' : 'Inhabilitado'}}
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
