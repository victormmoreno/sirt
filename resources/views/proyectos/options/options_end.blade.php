<div class="collection with-header col s12 m4 l4">
    <h5 class="collection-header">Opciones</h5>
    <ul class="collapsible">
        @can('showOptionsForFuncionarios', $proyecto)
            @can('showOptionsForAdministrador', $proyecto)
                <li>
                    <div class="collapsible-header"><i class="material-icons">library_books</i>Entregables</div>
                    <div class="collapsible-body">
                        <a href="{{route('proyecto.entregables.inicio', $proyecto->id)}}" class="collection-item">
                            <i class="material-icons left">library_books</i>
                            Adjuntar entregables de la fase de inicio.
                        </a>
                        <a href="{{route('proyecto.form.planeacion', $proyecto->id)}}" class="collection-item">
                            <i class="material-icons left">library_books</i>
                            Adjuntar entregables de la fase de planeación.
                        </a>
                        <a href="{{route('proyecto.form.ejecucion', $proyecto->id)}}" class="collection-item">
                            <i class="material-icons left">library_books</i>
                            Adjuntar entregables de la fase de ejecución.
                        </a>
                        <a class="collection-item" href="{{route('proyecto.entregables.cierre', $proyecto->id)}}">
                            <i class="material-icons left">library_books</i>
                            Adjuntar entregables de la fase de cierre.
                        </a>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">edit</i>Cambiar información</div>
                    <div class="collapsible-body">
                        <a href="{{route('proyecto.form.inicio', $proyecto->id)}}" class="collection-item">
                            <i class="material-icons left">edit</i>
                            Cambiar información de la fase de inicio.
                        </a>
                        <a class="collection-item" href="{{route('proyecto.form.cierre', $proyecto->id)}}">
                            <i class="material-icons left">edit</i>
                            Cambiar información de la fase de cierre.
                        </a>
                        <a href="{{route('proyecto.cambiar', $proyecto->id)}}" class="collection-item">
                            <i class="material-icons left">group</i>
                            Cambiar el experto del proyecto.
                        </a>
                        <a href="{{route('proyecto.cambiar.talentos', $proyecto->id)}}" class="collection-item">
                            <i class="material-icons left">group</i>
                            Cambiar talentos que desarrollan el proyecto.
                        </a>
                    </div>
                </li>
            @endcan
            <li>
                <div class="collapsible-header"><i class="material-icons">settings_backup_restore</i>Reversar proyecto</div>
                <div class="collapsible-body">
                    <a type="submit" onclick="preguntaReversar(event, {{$proyecto->id}}, 'Inicio')" value="send" class="collection-item">
                        <i class="material-icons left">settings_backup_restore</i>
                        Reversar proyecto a fase de inicio.
                    </a>
                    <a type="submit" onclick="preguntaReversar(event, {{$proyecto->id}}, 'Planeación')" value="send" class="collection-item">
                        <i class="material-icons left">settings_backup_restore</i>
                        Reversar proyecto a fase de planeación.
                    </a>
                    <a type="submit" onclick="preguntaReversar(event, {{$proyecto->id}}, 'Ejecución')" value="send" class="collection-item">
                        <i class="material-icons left">settings_backup_restore</i>
                        Reversar proyecto a fase de ejecución.
                    </a>
                    <a type="submit" onclick="preguntaReversar(event, {{$proyecto->id}}, 'Cierre')" value="send" class="collection-item">
                        <i class="material-icons left">settings_backup_restore</i>
                        Reversar proyecto a fase de cierre.
                    </a>
                </div>
            </li>
            @can('showOptionsForExperto', $proyecto)
                <li>
                    <div class="collapsible-header"><i class="material-icons">file_download</i>Generar documentos</div>
                    <div class="collapsible-body">
                        <a href="{{route('pdf.proyecto.inicio', $proyecto->id)}}" target="_blank" class="collection-item">
                            <i class="material-icons left">file_download</i>Generar acta de inicio.
                        </a>
                        <a href="{{route('pdf.proyecto.acta.inicio', $proyecto->id)}}" target="_blank" class="collection-item">
                            <i class="material-icons left">file_download</i>
                            Generar acta de categorización.
                        </a>
                        <a href="{{route('pdf.actividad.usos', [$proyecto->id, 'proyecto'])}}" class="collection-item" target="_blank">
                            <i class="material-icons left">file_download</i>
                            Descargar resumen de asesorias y usos de infraestructura.
                        </a>
                        <a class="collection-item" href="{{route('pdf.proyecto.cierre', $proyecto->id)}}" target="_blank">
                            <i class="material-icons left">file_download</i>
                            Generar acta de cierre.
                        </a>
                        <a href="{{route('proyecto.certificacion', $proyecto->id)}}" target="_blank" class="collection-item">
                            <i class="material-icons left">file_download</i>
                            Generar carta de certificación.
                        </a>
                    </div>
                </li>
            @endcan
        @else
            <li>
                <div class="collapsible-header"><i class="material-icons"></i>No tienes opciones disponibles</div>
            </li>
        @endcan
    </ul>
</div>