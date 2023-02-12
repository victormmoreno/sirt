@include('usoinfraestructura.pasos.usoinfraestructura')

@if(session()->has('login_role') && (session()->get('login_role') == App\User::IsExperto() || session()->get('login_role') == App\User::IsArticulador() ||  session()->get('login_role') == App\User::IsApoyoTecnico()))
    @include('usoinfraestructura.pasos.asesoria')
@endif
@include('usoinfraestructura.pasos.talento')

@include('usoinfraestructura.pasos.equipo')

@include('usoinfraestructura.pasos.material')

<div class="row">
    <div class="col s12 center-align m-t-sm">
        <button type="submit" class="waves-effect waves-grey btn bg-secondary center-align"><i class="material-icons right">done_all</i>{{isset($btnText) ? $btnText : 'Guardar'}}</button>
        <a class="waves-grey bg-danger btn center-align" href="{{route('usoinfraestructura.index')}}">
            <i class="material-icons right">
                backspace
            </i>
            Cancelar
        </a>
    </div>
</div>

