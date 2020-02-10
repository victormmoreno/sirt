<br>
<center>
    <span class="card-title center-align"><b>Proyecto -
            {{ $proyecto->articulacion_proyecto->actividad->codigo_actividad }}</b></span>
</center>
<div class="row">
    <div class="col s12">
        <ul class="tabs">
            <li class="tab col s3"><a onclick="changeToInicio()" href="#">Inicio</a>
            </li>
            <li class="tab col s3"><a onclick="changeToPlaneacion()" href="#">Planeación</a></li>
            <li class="tab col s3"><a onclick="">Ejecución</a></li>
            <li class="tab col s3"><a onclick="">Cierre</a></li>
        </ul>
    </div>
</div>