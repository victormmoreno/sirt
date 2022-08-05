<form action="{{route('proyecto.aprobacion', [$proyecto->id])}}" method="POST" name="frmAprobacionProyecto">
    {!! method_field('PUT')!!}
    @csrf
    <div class="divider"></div>
    <center>
        @include('proyectos.botones_aprobacion_component')
        <a href="{{route('proyecto')}}" class="waves-effect red lighten-2 btn center-aling">
            <i class="material-icons right">backspace</i>Cancelar
        </a>
    </center>
</form>