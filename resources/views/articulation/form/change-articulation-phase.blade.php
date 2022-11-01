@if($articulation->phase->nombre != \App\Models\Articulation::IsCierre())
<form action="{{route('articulation.change-next-phase', [$articulation, $articulation->phase->nombre == \App\Models\Articulation::IsInicio() ? 'ejecucion': ($articulation->phase->nombre == \App\Models\Articulation::IsEjecucion() ? 'cierre': 'inicio')])}}" method="POST" style="width: 100%" name="frmChangeNextPhase">
    {!! method_field('PUT')!!}
    @csrf
    <button type="submit" onclick="changeNextPhaseArticulation(event)" class="center-align center waves-effect waves-light btn orange btn-large modal-trigger" style="margin-bottom: 10px; margin-right: 10px; margin-top: 10px; width: 100%;">
        <i class="material-icons right">done</i>
        ir a la fase {{$articulation->phase->nombre == \App\Models\Articulation::IsInicio() ? 'ejecucion': ($articulation->phase->nombre == \App\Models\Articulation::IsEjecucion() ? 'cierre': 'inicio')}}
    </button>
</form>
@endif
@if($articulation->phase->nombre != \App\Models\Articulation::IsInicio())
    <form action="{{route('articulation.change-previus-phase', [$articulation, $articulation->phase->nombre == \App\Models\Articulation::IsEjecucion() ? 'inicio': ($articulation->phase->nombre == \App\Models\Articulation::IsCierre() ? 'ejecucion': 'inicio')])}}" method="POST" style="width: 100%" name="frmChangePreviusPhase">
        {!! method_field('PUT')!!}
        @csrf
        <button type="submit" onclick="changePreviusPhaseArticulation(event)" class="center-align center waves-effect waves-light btn orange btn-large modal-trigger" style="margin-bottom: 10px; margin-right: 10px; margin-top: 10px; width: 100%;">
            <i class="material-icons right">done</i>
            ir a la fase {{$articulation->phase->nombre == \App\Models\Articulation::IsEjecucion() ? 'inicio': ($articulation->phase->nombre == \App\Models\Articulation::IsCierre() ? 'ejecución': 'inicio')}}
        </button>
    </form>
@endif
