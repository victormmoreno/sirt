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
@if (Session::get('login_role') == App\User::IsGestor() || Session::get('login_role') == App\User::IsDinamizador())
<div class="divider"></div>
<div class="row">
    <div class="col s12 m4 l4">
        <a href="{{route('proyecto.suspender', $proyecto->id)}}">
            <div class="card-panel red lighten-3 black-text center">
                Suspender proyecto.
            </div>
        </a>
    </div>
    <div class="col s12 m4 l4">
        <a href="{{route('proyecto.cambiar', $proyecto->id)}}">
            <div class="card-panel green lighten-3 black-text center">
                Cambiar el gestor del proyecto.
            </div>
        </a>
    </div>
    @if (Session::get('login_role') == App\User::IsDinamizador())
        <div class="col s12 m4 l4">
            <form action="{{route('proyecto.reversar', $proyecto->id)}}" method="POST" name="frmReversarFase">
                {!! method_field('PUT')!!}
                @csrf
                <button type="submit" onclick="preguntaReversar(event)" value="send" class="btn-flat">
                    Reversar fase del proyecto a Inicio.
                </button>
            </form>
        </div>
    @endif
</div>
    <div class="col s12 m12 l12">
        @include('proyectos.historial_cambios')
    </div>
@endif