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
        <th>Código de Proyecto/Articulacion</th>
        <th>Nit de la Empresa</th>
        <th>Nombre de la Empresa</th>
    </tr>
    </thead>
    <tbody>
      @foreach($empresas as $value)
        <tr>
          <td>{{ $value->codigo_actividad }}</td>
          <td>{{ $value->nit }}</td>
          <td>{{ $value->nombre }}</td>
        </tr>
      @endforeach
    </tbody>
</table>
