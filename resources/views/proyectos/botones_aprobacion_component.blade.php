@if ($ult_notificacion != null)
    @if ($ult_notificacion->receptor->id == auth()->user()->id && $ult_notificacion->rol_receptor->name == Session::get('login_role') && $ult_notificacion->estado == $ult_notificacion->IsPendiente())
        <input type="hidden" type="text" name="motivosNoAprueba" id="motivosNoAprueba">
        <input type="hidden" type="text" name="control_notificacion_id" id="control_notificacion_id" value="{{$ult_notificacion->id}}">
        <input type="hidden" type="text" name="decision" id="decision">
        <button type="submit" onclick="preguntaRechazarAprobacionProyecto(event)" class="waves-effect deep-orange darken-1 btn center-aling">
            <i class="material-icons right">close</i>
            No aprobar la fase de {{$proyecto->fase->nombre}}
        </button>
        <button type="submit" onclick="preguntaAprobacion(event)" class="waves-effect cyan darken-1 btn center-aling">
            <i class="material-icons right">done</i>
            Aprobar fase de {{$proyecto->fase->nombre}}
        </button>
    @endif
@endif