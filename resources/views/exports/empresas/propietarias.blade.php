<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<br>
<br>
<br>
<br>
<br>
<br>
<table>
    <thead>
    <tr>
        <th>Código de Proyecto</th>
        <th>Nit de la empresa</th>
        <th>Codigo CIIU</th>
        <th>Nombre de la empresa</th>
        <th>Fecha de creación de la empresa</th>
        <th>Sector</th>
        <th>Ciudad</th>
        <th>Dirección</th>
        <th>Email de la empresa</th>
        <th>Tamaño de la empresa</th>
        <th>Tipo de empresa</th>
    </tr>
    </thead>
    <tbody>
      @foreach($empresas as $value)
        <tr>
          <td>{{ $value->codigo_actividad }}</td>
          <td>{{ $value->nit }}</td>
          <td>{{ $value->codigo_ciiu }}</td>
          <td>{{ $value->nombre_empresa }}</td>
          <td>{{ $value->fecha_creacion }}</td>
          <td>{{ $value->nombre_sector }}</td>
          <td>{{ $value->ciudad }}</td>
          <td>{{ $value->direccion }}</td>
          <td>{{ $value->email_entidad }}</td>
          <td>{{ $value->tamanho_empresa }}</td>
          <td>{{ $value->tipo_empresa }}</td>
        </tr>
      @endforeach
    </tbody>
</table>
