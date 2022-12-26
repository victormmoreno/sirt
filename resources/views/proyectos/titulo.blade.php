<center>
    <span class="card-title center-align"><b>Proyecto - {{ $proyecto->present()->proyectoCode() }}</b></span>
</center>
<div class="row card-panel green lighten-5">
    <h5 class="center">Este proyecto se encuentra actualmente en fase de {{$proyecto->fase->nombre}}</h5>
</div>
<div class="divider"></div>