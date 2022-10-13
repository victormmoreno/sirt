@if($articulation->phase->nombre != \App\Models\Articulation::IsCierre())
<form action="{{route('articulation.manage-change-phase', [$articulation, $articulation->phase->nombre == \App\Models\Articulation::IsInicio() ? 'ejecucion': ($articulation->phase->nombre == \App\Models\Articulation::IsEjecucion() ? 'cierre': 'inicio')])}}" method="POST" style="width: 100%" name="frmChangeArticulationPhase">
    {!! method_field('PUT')!!}
    @csrf
    <button type="submit" onclick="changePhaseArticulation(event)" class="center-align center waves-effect waves-light btn orange btn-large modal-trigger" style="margin-bottom: 10px; margin-right: 10px; margin-top: 10px; width: 100%;">
        <i class="material-icons right">done</i>
        ir a la fase {{$articulation->phase->nombre == \App\Models\Articulation::IsInicio() ? 'ejecucion': ($articulation->phase->nombre == \App\Models\Articulation::IsEjecucion() ? 'cierre': 'inicio')}}
    </button>
</form>
    @endif
