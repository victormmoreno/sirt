<a href="{{route('proyecto.cambiar', $proyecto->id)}}" class="collection-item">
    <i class="material-icons left">group</i>
    Cambiar el experto del proyecto.
</a>
<a type="submit" onclick="preguntaReversar(event, {{$proyecto->id}},'Inicio')" value="send" class="collection-item">
    <i class="material-icons left">settings_backup_restore</i>
    Reversar proyecto a fase de inicio.
</a>