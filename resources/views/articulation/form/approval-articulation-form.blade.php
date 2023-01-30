<form action="{{route('articulations.manage-approval', [$articulation->id, $articulation->phase_id == \App\Models\Fase::IsCierre() ? 'Finalizado' : 'Cierre'])}}" method="POST" style="width: 100%" id="frmApprovalArticulations">
    {!! method_field('PUT')!!}
    @csrf
    @if(isset($ult_notificacion))
        <input type="hidden" type="text" name="motivosNoAprueba" id="motivosNoAprueba">
        <input type="hidden" type="text" name="control_notificacion_id" id="control_notificacion_id" value="{{$ult_notificacion->id}}">
        <input type="hidden" type="text" name="decision" id="decision">
        <button type="submit" onclick="endorsementQuestionArticulation(event)" class="center-align center waves-effect waves-light btn bg-secondary btn-large modal-trigger" style="margin-bottom: 10px; margin-right: 10px; margin-top: 10px; width: 100%;">
            <i class="material-icons left">done</i>
            Aprobar aval
        </button>
        <button type="submit" onclick="questionRejectEndorsementArticulation(event)" class="center-align waves-effect waves-light btn bg-danger modal-trigger" style="margin-bottom: 10px; margin-right: 10px; margin-top: 0px; width: 100%">
            <i class="material-icons left">close</i>
            No aprobar aval
        </button>
    @endif
</form>
