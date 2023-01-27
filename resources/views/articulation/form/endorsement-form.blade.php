<form action="{{route('articulation-stage.manage-endorsement', [$articulationStage->id, $articulationStage->endorsement == \App\Models\ArticulationStage::ENDORSEMENT_NO ? 'abrir' : 'cerrar'])}}" method="POST" style="width: 100%" name="frmEndorsementArticulationStage">
    {!! method_field('PUT')!!}
    @csrf
    @if(isset($ult_notificacion))
        <input type="hidden" type="text" name="motivosNoAprueba" id="motivosNoAprueba">
        <input type="hidden" type="text" name="control_notificacion_id" id="control_notificacion_id" value="{{$ult_notificacion->id}}">
        <input type="hidden" type="text" name="decision" id="decision">
        @if ($articulationStage->endorsement == \App\Models\ArticulationStage::ENDORSEMENT_NO )
            <button type="submit" onclick="endorsementQuestionArticulationStage(event, 'abrir')" class="center-align center waves-effect waves-light btn bg-secondary btn-large modal-trigger" style="margin-bottom: 10px; margin-right: 10px; margin-top: 10px; width: 100%;">
                <i class="material-icons right">done</i>
                Aprobar aval {{$articulationStage->present()->articulationStageEndorsementApproval()}}
            </button>
            <button type="submit" onclick="questionRejectEndorsementArticulationStage(event)" class="center-align waves-effect waves-light btn bg-danger modal-trigger" style="margin-bottom: 10px; margin-right: 10px; margin-top: 0px; width: 100%">
                <i class="material-icons right">close</i>
                No aprobar aval {{$articulationStage->present()->articulationStageEndorsementApproval()}}
            </button>
        @elseif ($articulationStage->endorsement == \App\Models\ArticulationStage::ENDORSEMENT_YES)
            <button type="submit" onclick="endorsementQuestionArticulationStage(event)" class="center-align center waves-effect waves-light btn bg-secondary btn-large modal-trigger" style="margin-bottom: 10px; margin-right: 10px; margin-top: 10px; width: 100%;">
                <i class="material-icons right">done</i>
                Aprobar aval {{$articulationStage->present()->articulationStageEndorsementApproval()}}
            </button>
            <button type="submit" onclick="questionRejectEndorsementArticulationStage(event)" class="center-align waves-effect waves-light btn bg-danger modal-trigger" style="margin-bottom: 10px; margin-right: 10px; margin-top: 0px; width: 100%">
                <i class="material-icons right">close</i>
                No aprobar aval {{$articulationStage->present()->articulationStageEndorsementApproval()}}
            </button>
        @else
            <button type="submit" class="center-align center waves-effect waves-light btn bg-secondary modal-trigger" style="margin-bottom: 10px; margin-right: 10px; margin-top: 0px; width: 100%;" disabled>
                <i class="material-icons right">done</i>
                Ya está avalada
            </button>
        @endif
    @endif
</form>
