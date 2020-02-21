<br>
<center>
    <span class="card-title center-align"><b>Proyecto -
            {{ $proyecto->articulacion_proyecto->actividad->codigo_actividad }}</b></span>
</center>
<div class="row card-panel green lighten-5">
    <h5 class="center">Este proyecto se encuentra actualmente en fase de {{$proyecto->fase->nombre}}</h5>
</div>
<div class="divider"></div>
<div class="row">
    <div class="col s12">
        <ul class="tabs">
            <li class="tab col s3"><a class="{{setActiveRoute('proyecto/inicio')}}" onclick="changeToInicio()" href="#">Inicio</a></li>
            <li class="tab col s3"><a class="{{setActiveRoute('proyecto/planeacion')}}" onclick="changeToPlaneacion()" href="#">Planeación</a></li>
            <li class="tab col s3"><a class="{{setActiveRoute('proyecto/ejecucion')}}" onclick="changeToEjecucion()" href="#">Ejecución</a></li>
            <li class="tab col s3"><a class="{{setActiveRoute('proyecto/cierre')}}" onclick="changeToCierre()" href="#">Cierre</a></li>
        </ul>
    </div>
</div>