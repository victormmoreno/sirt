<a class="collection-item" href="{{route('pdf.proyecto.cierre', $proyecto->id)}}" target="_blank">
    <i class="material-icons left">file_download</i>
    Generar acta de cierre.
</a>
<a class="collection-item" href="{{route('proyecto.entregables.cierre', $proyecto->id)}}">
    <i class="material-icons left">library_books</i>
    Adjuntar entregables de la fase de cierre.
</a>
<a class="collection-item" href="{{route('proyecto.form.cierre', $proyecto->id)}}">
    <i class="material-icons left">edit</i>
    Cambiar información de la fase de cierre.
</a>