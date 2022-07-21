@if (\Session::get('login_role') == App\User::IsActivador() || \Session::get('login_role') == App\User::IsDinamizador() || \Session::get('login_role') == App\User::IsTalento())
    @if ($idea->estadoIdea->nombre == 'Admitido' || $idea->estadoIdea->nombre == 'En registro' || $idea->estadoIdea->nombre == 'Postulado')
        <li class="collection-item">
            <form action="{{route('idea.inhabilitar', $idea->id)}}" method="POST" id="frmInhabilitarIdea" name="frmInhabilitarIdea">
            {!! method_field('PUT')!!}
            <input type="hidden" value="{{$idea}}" name="txtidea_id">
            @csrf
            <a href="" onclick="confirmacionInhabilitar(event)">
                <div class="card-panel orange lighten-2 black-text center">
                Inhabilitar idea de proyecto.
                </div>
            </a>
            </form>
        </li>
    @endif
@endif