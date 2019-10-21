@include('usoinfraestructura.pasos.usoinfraestructura')

@if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
    @include('usoinfraestructura.pasos.asesoria')
@endif
<div class="divider"></div>
@include('usoinfraestructura.pasos.talento')
<div class="divider"></div>

@include('usoinfraestructura.pasos.equipo')
<div class="divider"></div>
@include('usoinfraestructura.pasos.material')

<div class="divider"></div>
<center>
   
    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>{{isset($btnText) ? $btnText : 'Guardar'}}</button> 
    <a class="btn waves-effect red lighten-2 center-aling" href="{{route('usoinfraestructura.index')}}">
        <i class="material-icons right">
            backspace
        </i>
        Cancelar
    </a>
</center>