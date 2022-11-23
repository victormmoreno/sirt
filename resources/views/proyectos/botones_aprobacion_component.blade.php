@if ($ult_notificacion != null)
    @if ($ult_notificacion->receptor->id == auth()->user()->id && $ult_notificacion->rol_receptor->name == Session::get('login_role') && $ult_notificacion->estado == $ult_notificacion->IsPendiente())
        <input type="hidden" type="text" name="motivosNoAprueba" id="motivosNoAprueba">
        <input type="hidden" type="text" name="control_notificacion_id" id="control_notificacion_id" value="{{$ult_notificacion->id}}">
        <input type="hidden" type="text" name="decision" id="decision">
        @if ($ult_notificacion->fase->nombre == App\Models\Proyecto::IsSuspendido())
            <button type="submit" onclick="preguntaSuspendido(event)" class="waves-effect bg-primary white-text btn center-aling">
                <i class="material-icons right">done</i>
                Aprobar la suspensión del proyecto
            </button>
        @else
            @if ( url()->current() == $proyecto->present()->proyectoRutaActual() )
                <button type="submit" onclick="preguntaRechazarAprobacionProyecto(event)" class="waves-effect bg-secondary white-text btn center-aling">
                    <i class="material-icons right">close</i>
                    No aprobar la fase de {{$proyecto->fase->nombre}}
                </button>
                <button type="submit" onclick="preguntaAprobacion(event)" class="waves-effect bg-primary white-text btn center-aling">
                    <i class="material-icons left">done</i>
                    Aprobar fase de {{$proyecto->fase->nombre}}
                </button>
            @else
            <button type="submit" class="waves-effect bg-primary  btn center-aling" disabled>
                <i class="material-icons left">done</i>
                Esta fase ya ha sido aprobada
            </button>
            @endif
        @endif
    @endif
@endif
