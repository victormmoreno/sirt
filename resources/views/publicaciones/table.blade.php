<table id="{{$id}}" style="width: 100%">
  <thead>
    @if ($rol == 'Desarrollador')
      <th>Código</th>
    @endif
    <th>Fecha</th>
    <th>Título</th>
    @if ($rol == 'Desarrollador')
      <th>Rol</th>
    @endif
    <th>Ver</th>
    @if ($rol == 'Desarrollador')
      <th>Editar</th>
      <th>Cambiar de Estado</th>
    @endif
  </thead>
</table>
