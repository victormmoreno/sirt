<form action="{{route('proyecto.aprobacion', [$proyecto->id])}}" method="POST" name="frmAprobacionProyecto">
    {!! method_field('PUT')!!}
    @csrf
    <div class="divider"></div>
    <div class="center-align">
        @include('proyectos.botones_aprobacion_component')
        <a href="{{route('proyecto')}}" class="waves-effect bg-danger btn center-aling">
            <i class="material-icons right">backspace</i>Cancelar
        </a>
    </div>
</form>
