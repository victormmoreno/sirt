<div class="row">
    <div class="col s12">
        <ul class="tabs">
            <li class="tab col s3"><a class="{{setActiveRoute('proyecto/inicio')}}" href="{{route('proyecto.inicio', $proyecto->id)}}" target="_self">Inicio</a></li>
            <li class="tab col s3"><a class="{{setActiveRoute('proyecto/planeacion')}}" href="{{route('proyecto.planeacion', $proyecto->id)}}" target="_self">Planeación</a></li>
            <li class="tab col s3"><a class="{{setActiveRoute('proyecto/ejecucion')}}" href="{{route('proyecto.ejecucion', $proyecto->id)}}" target="_self">Ejecución</a></li>
            <li class="tab col s3"><a class="{{setActiveRoute('proyecto/cierre')}}" href="{{route('proyecto.cierre', $proyecto->id)}}" target="_self">Cierre</a></li>
        </ul>
    </div>
</div>