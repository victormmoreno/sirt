<a href="{{route('proyecto.form.ejecucion', $proyecto->id)}}" class="collection-item">
    <i class="material-icons left">library_books</i>
    Adjuntar entregables de la fase de ejecución.
</a>
<a href="{{route('pdf.actividad.usos', [$proyecto->id, 'proyecto'])}}" class="collection-item" target="_blank">
    <i class="material-icons left">file_download</i>
    Descargar resumen de asesorias y usos de infraestructura.
</a>