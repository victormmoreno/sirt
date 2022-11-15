<form action="{{route('proyecto.update.suspendido', [$proyecto->id])}}" method="POST" name="frmSuspendidoDinamizador">
    {!! method_field('PUT')!!}
    @csrf
    <div class="divider"></div>
    <div class="center-align">
        @include('proyectos.botones_aprobacion_component')
        <a href="{{route('proyecto')}}" class="waves-effect bg-danger white-text btn center-aling">
            <i class="material-icons right">backspace</i> Cancelar
        </a>
    </div>
</form>
