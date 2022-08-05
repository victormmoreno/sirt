<a href="{{route('proyecto.cambiar', $proyecto->id)}}" class="collection-item">
    <i class="material-icons left">group</i>
    Cambiar el experto del proyecto.
</a>
<a type="submit" onclick="preguntaReversar(event)" value="send" class="collection-item">
    <form action="{{route('proyecto.reversar', [$proyecto->id, 'Inicio'])}}" method="POST" name="frmReversarFase">
    {!! method_field('PUT')!!}
    @csrf
        <i class="material-icons left">settings_backup_restore</i>
        Reversar proyecto a fase de inicio.
    </form>
</a>