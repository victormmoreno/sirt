@if ($ult_notificacion != null)
    @if ($ult_notificacion->receptor->id == auth()->user()->id && $ult_notificacion->rol_receptor->name == Session::get('login_role') && $ult_notificacion->estado == $ult_notificacion->IsPendiente())
        <input type="hidden" type="text" name="motivosNoAprueba" id="motivosNoAprueba">
        <input type="hidden" type="text" name="control_notificacion_id" id="control_notificacion_id" value="{{$ult_notificacion->id}}">
        <input type="hidden" type="text" name="decision" id="decision">
        @if ( url()->current() == route(' articulation-stage.show', $articulationStage))
        <button type="submit" onclick="preguntaAprobacion(event)" class="waves-effect waves-orange btn orange m-t-xs">
            <i class="material-icons right">done</i>
            Aprobar {{ __('articulation-stage') }}
        </button>
        <button type="submit" onclick="preguntaRechazarAprobacionProyecto(event)" class="waves-effect waves-orange btn-flat m-t-xs">
            <i class="material-icons right">close</i>
            No aprobar {{ __('articulation-stage') }}
        </button>
        @else
            <button type="submit" class="waves-effect cyan darken-1 btn center-aling" disabled>
                <i class="material-icons right">done</i>
                {{ __('articulation-stage') }} aprobada
            </button>
        @endif
    @endif
@endif
