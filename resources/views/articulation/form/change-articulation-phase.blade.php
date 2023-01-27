@if($articulation->phase->nombre != \App\Models\Articulation::IsFinalizado())
<div class="wizard clearfix">
    <div class="actions clearfix right-align">
        <ul role="menu" aria-label="Paginación">
            @if($articulation->phase->nombre != \App\Models\Articulation::IsInicio())
                <li class="disabled" aria-disabled="true">
                    <form class="left-align"
                        action="{{route('articulation.change-previus-phase', [$articulation, $articulation->phase->nombre == \App\Models\Articulation::IsEjecucion() ? 'inicio': ($articulation->phase->nombre == \App\Models\Articulation::IsCierre() ? 'ejecucion': 'inicio')])}}"
                        method="POST" style="width: 100%" name="frmChangePreviusPhase">
                        {!! method_field('PUT')!!}
                        @csrf
                        <button type="submit" onclick="changePreviusPhaseArticulation(event)"
                                class="left-align waves-effect waves-grey bg-secondary white-text btn-flat"
                                style="margin-bottom: 10px; margin-right: 10px; margin-top: 10px; width: 100%;">
                            <i class="material-icons left">arrow_back</i>
                            ir a la
                            fase {{$articulation->phase->nombre == \App\Models\Articulation::IsEjecucion() ? 'inicio': ($articulation->phase->nombre == \App\Models\Articulation::IsCierre() ? 'ejecución': 'inicio')}}
                        </button>
                    </form>
                </li>
            @endif
            @if($articulation->phase->nombre != \App\Models\Articulation::IsCierre())
                <li aria-hidden="false" aria-disabled="false">
                    <form class="right-align"
                            action="{{route('articulation.change-next-phase', [$articulation, $articulation->phase->nombre == \App\Models\Articulation::IsInicio() ? 'ejecucion': ($articulation->phase->nombre == \App\Models\Articulation::IsEjecucion() ? 'cierre': 'inicio')])}}"
                            method="POST" style="width: 100%" name="frmChangeNextPhase">
                        {!! method_field('PUT')!!}
                        @csrf
                        <button type="submit" onclick="changeNextPhaseArticulation(event)" role="menuitem"
                                class="right-align waves-effect waves-grey bg-secondary white-text btn-flat"
                                style="margin-bottom: 10px; margin-right: 10px; margin-top: 10px; width: 100%;">
                            <i class="material-icons right">arrow_forward</i>
                            ir a la
                            fase {{$articulation->phase->nombre == \App\Models\Articulation::IsInicio() ? 'ejecucion': ($articulation->phase->nombre == \App\Models\Articulation::IsEjecucion() ? 'cierre': 'inicio')}}
                        </button>
                    </form>
                </li>
            @endif
        </ul>
    </div>
</div>
@endif


