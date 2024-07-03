<ul class="tabs">
    @if ($proyecto->fase->nombre != $proyecto->IsFinalizado() && $proyecto->fase->nombre != $proyecto->IsSuspendido())
        <li class="tab col s3"><a class="{{setActiveRoute('proyecto/inicio')}}" href="{{route('proyecto.inicio', $proyecto->id)}}" target="_self">Inicio</a></li>
        <li class="tab col s3"><a class="{{setActiveRoute('proyecto/planeacion')}}" href="{{route('proyecto.planeacion', $proyecto->id)}}" target="_self">Planeación</a></li>
        <li class="tab col s3"><a class="{{setActiveRoute('proyecto/ejecucion')}}" href="{{route('proyecto.ejecucion', $proyecto->id)}}" target="_self">Ejecución</a></li>
        <li class="tab col s3"><a class="{{setActiveRoute('proyecto/cierre')}}" href="{{route('proyecto.cierre', $proyecto->id)}}" target="_self">Cierre</a></li>
    @else
        <li class="tab col s3"><a class="active" href="#inicio">Inicio</a></li>
        <li class="tab col s3"><a href="#planeacion">Planeación</a></li>
        <li class="tab col s3"><a href="#ejecucion">Ejecución</a></li>
        <li class="tab col s3"><a href="#cierre">Cierre</a></li>
        @if ($proyecto->fase->nombre == $proyecto->IsSuspendido())
            <li class="tab col s3"><a href="#cancelado" class="white-text red lighten-3">Cancelado</a></li>
        @endif
    @endif
</ul>