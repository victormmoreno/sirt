<a href="{{route('pdf.form.doc', [Proyecto::class, 'inicio', $proyecto->id])}}" target="_blank" class="collection-item">
    <i class="material-icons left">file_download</i>Generar acta de inicio.
</a>
<a href="{{route('pdf.proyecto.acta.inicio', $proyecto->id)}}" target="_blank" class="collection-item">
    <i class="material-icons left">file_download</i>
    Generar acta de categorización.
</a>
<a href="{{route('proyecto.entregables.inicio', $proyecto->id)}}" class="collection-item">
    <i class="material-icons left">library_books</i>
    Adjuntar entregables de la fase de inicio.
</a>
<a href="{{route('proyecto.form.inicio', $proyecto->id)}}" class="collection-item">
    <i class="material-icons left">edit</i>
    Cambiar información de la fase de inicio.
</a>