@php
    $dates = new Carbon\Carbon();
    // Carbon::parse($row['fecha_de_adquisicion'])->format('Y-m-d');
@endphp
<table>
    <thead>
    <tr>
        <th>Código de material</th>
        <th>Nodo</th>
        <th>Linea</th>
        <th>Nombre</th>
        <th>Fecha de adquisición</th>
        <th>Categoria</th>
        <th>Presentación</th>
        <th>Medida</th>
        <th>Cantidad</th>
        <th>Valor de compra</th>
        <th>Proveedor</th>
        <th>Marca</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($materiales as $material)
        <tr>
            <td>{{ $material->codigo_material }}</td>
            <td>{{ $material->nodo }}</td>
            <td>{{ $material->linea }}</td>
            <td>{{ $material->material }}</td>
            <td>{{ $dates::parse($material->fecha)->format('Y-m-d') }}</td>
            <td>{{ $material->categoria_material }}</td>
            <td>{{ $material->presentacion }}</td>
            <td>{{ $material->medida }}</td>
            <td>{{ $material->cantidad }}</td>
            <td>{{ $material->valor_compra }}</td>
            <td>{{ $material->proveedor }}</td>
            <td>{{ $material->marca }}</td>
          </tr>
        @endforeach
    </tbody>
</table>
