<table>
    <thead>
        <tr>
            <th >Nodo</th>
            <th >Código</th>
            <th >Fecha</th>
            <th >Tipo Asesoria</th>
            <th >Nombre</th>
            <th >Descripción</th>
            <th >Próximos compromisos</th>
            <th >Fase</th>
            <th >Asesor(a)</th>
            <th >Talentos</th>
            <th >Equipos</th>
            <th >Materiales de Formación</th>
        </tr>
    </thead>
    <tbody>
        @forelse($asesories as $asesorie)
        <tr>
            <td>
                {{$asesorie->nodo}}
            </td>
            <td>
                {{$asesorie->codigo}}
            </td>
            <td>
                {{optional($asesorie->fecha)->isoFormat('YYYY-MM-DD')}}
            </td>
            <td>
                {{$asesorie->tipo_asesoria}}
            </td>
            <td>
                {{$asesorie->nombre}}
            </td>
            <td>
                {{$asesorie->descripcion}}
            </td>
            <td>
                {{$asesorie->compromisos}}
            </td>
            <td>
                {{$asesorie->fase}}
            </td>
            <td>
                {{$asesorie->asesores}}
            </td>
            <td>
                {{$asesorie->participants}}
            </td>
            <td>
                {{$asesorie->equipos}}
            </td>
            <td>
                {{$asesorie->materiales}}
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
