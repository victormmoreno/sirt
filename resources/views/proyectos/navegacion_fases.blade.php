<br>
@include('proyectos.titulo')
@include('proyectos.historial_cambios')
@if (Session::get('login_role') == App\User::IsGestor() || Session::get('login_role') == App\User::IsDinamizador())
<div class="divider"></div>
<div class="row">
    <div class="col s12 m4 l4">
        <a href="{{route('proyecto.suspender', $proyecto->id)}}">
            <div class="card-panel bg-danger white-text center">
                Suspender proyecto.
            </div>
        </a>
    </div>
    <div class="col s12 m4 l4">
        <a href="{{route('proyecto.cambiar', $proyecto->id)}}">
            <div class="card-panel bg-success white-text center">
                Cambiar el experto del proyecto.
            </div>
        </a>
    </div>
    @if (Session::get('login_role') == App\User::IsDinamizador())
        <div class="col s12 m4 l4">
            <form action="{{route('proyecto.reversar', [$proyecto->id, 'Inicio'])}}" method="POST" name="frmReversarFase">
                {!! method_field('PUT')!!}
                @csrf
                <button type="submit" onclick="preguntaReversar(event)" value="send" class="waves-effect bg-warning text-white btn center-aling m-t-md m-l-lg">
                    Reversar fase del proyecto a Inicio.
                </button>
            </form>
        </div>
    @endif
    @if (Session::get('login_role') == App\User::IsGestor())
        <div class="col s12 m4 l4">
            <a href="{{route('proyecto.cambiar.talentos', $proyecto->id)}}">
                <div class="card-panel blue lighten-3 black-text center">
                    Cambiar talentos que desarrollan el proyecto.
                </div>
            </a>
        </div>
    @endif
</div>
@endif
