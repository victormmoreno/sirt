<br>
<center>
    <span class="card-title center-align"><b>Articulación -
            {{ $articulacion->articulacion_proyecto->actividad->codigo_actividad }}</b></span>
</center>
<div class="row card-panel green lighten-5">
    <h5 class="center">Esta articulación se encuentra actualmente en fase de {{$articulacion->fase->nombre}}</h5>
</div>
<div class="divider"></div>
<div class="row">
    <div class="col s12">
        <ul class="tabs">
            <li class="tab col s3"><a class="{{setActiveRoute('articulacion/inicio')}}" onclick="changeToInicio()" href="#">Inicio</a></li>
            <li class="tab col s3"><a class="{{setActiveRoute('articulacion/planeacion')}}" onclick="changeToPlaneacion()" href="#">Planeación</a></li>
            <li class="tab col s3"><a class="{{setActiveRoute('articulacion/ejecucion')}}" onclick="changeToEjecucion()" href="#">Ejecución</a></li>
            <li class="tab col s3"><a class="{{setActiveRoute('articulacion/cierre')}}" onclick="changeToCierre()" href="#">Cierre</a></li>
        </ul>
    </div>
</div>
@if (Session::get('login_role') == App\User::IsGestor() || Session::get('login_role') == App\User::IsDinamizador())
<div class="divider"></div>
<div class="row">
    {{-- <div class="col s12 m4 l4">
        <a href="">
            <div class="card-panel red lighten-3 black-text center">
                Suspender articulación.
            </div>
        </a>
    </div> --}}
    <div class="col s12 m8 l8">
        @include('articulaciones.historial_cambios')
    </div>
</div>
@endif