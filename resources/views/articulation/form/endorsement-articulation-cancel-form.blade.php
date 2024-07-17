<form action="{{route('articulations.manage-approval', [$articulation->id, \App\Models\Articulation::IsCancelado()])}}" method="POST" style="width: 100%" name="frmEndorsementArticulationCancel">
    {!! method_field('PUT')!!}
    @csrf
    @if(isset($ult_notificacion))
        <input type="hidden" type="text" name="motivosNoAprueba" id="motivosNoAprueba">
        <input type="hidden" type="text" name="control_notificacion_id" id="control_notificacion_id" value="{{$ult_notificacion->id}}">
        <input type="hidden" type="text" name="decision" id="decision">
        @if ($ult_notificacion->fase->nombre != \App\Models\Articulation::IsCancelado())
            <button type="submit" onclick="endorsementQuestionArticulationCancel(event, 'Cancelado')" class="center-align center waves-effect waves-light btn bg-secondary btn-large modal-trigger" style="margin-bottom: 10px; margin-right: 10px; margin-top: 10px; width: 100%;">
                <i class="material-icons right">done</i>
                Aprobar Cancelación
            </button>
            <button type="submit" onclick="questionRejectEndorsementArticulationCancel(event)" class="center-align waves-effect waves-light btn bg-danger modal-trigger" style="margin-bottom: 10px; margin-right: 10px; margin-top: 0px; width: 100%">
                <i class="material-icons right">close</i>
                No aprobar Cancelación
            </button>
        @endif
    @endif
</form>
