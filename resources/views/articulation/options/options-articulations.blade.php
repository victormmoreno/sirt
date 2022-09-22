<div class="mailbox-view-header">
    <div class="left">
        <div class="left">
            <span class="mailbox-title">{{$articulationStage->code}} - {{$articulationStage->name}}
            @can('update', $articulationStage)
                <a href="{{route('articulation-stage.edit', $articulationStage)}}" class="orange-text text-darken-2 pointer tooltipped" data-position="right" data-tooltip="editar {{__('articulation-stage')}}"><i class="tiny material-icons">edit</i></a></span>
            @endcan
            <span class="mailbox-title">{{__('Node')}} {{$articulationStage->present()->articulationStageNode()}}</span>
            <span class="mailbox-author">{{$articulationStage->present()->articulationStageInterlocutorTalent()}} ({{__('Interlocutory talent')}})
                @can('changeTalent', $articulationStage)
                    <a href="{{ route('articulation-stage.changeinterlocutor', $articulationStage) }}" class="orange-text text-darken-2 pointer tooltipped" data-position="right" data-tooltip="cambiar {{__('Interlocutory talent')}}"><i class="tiny material-icons">edit</i></a>
                @endcan
            </span>
        </div>
    </div>
    <div class="right mailbox-buttons">
        @can('create', App\Models\Articulation::class)
                @if($articulationStage->articulations_count > 0)
                <a href="{{route('articulations.create', $articulationStage->id )}}"
                   class="waves-effect waves-orange btn orange m-t-xs">{{ __('New Articulation') }}</a>
                @endif
            @endcan
            <form action="{{route('proyecto.aprobacion', [$articulationStage->id])}}" method="POST" name="frmAprobacionProyecto">
                {!! method_field('PUT')!!}
                @csrf
                @if ($ult_notificacion != null)
                    @if ($ult_notificacion->receptor->id == auth()->user()->id && $ult_notificacion->rol_receptor->name == Session::get('login_role') && $ult_notificacion->estado == $ult_notificacion->IsPendiente())
                        <input type="hidden" type="text" name="motivosNoAprueba" id="motivosNoAprueba">
                        <input type="hidden" type="text" name="control_notificacion_id" id="control_notificacion_id" value="{{$ult_notificacion->id}}">
                        <input type="hidden" type="text" name="decision" id="decision">

                            @if ( $ult_notificacion)
                                <button type="submit" onclick="preguntaRechazarAprobacionProyecto(event)" class="waves-effect deep-orange darken-1 btn center-aling mt-5">
                                    <i class="material-icons right">close</i>
                                    No Aprobar aval
                                </button>
                                <button type="submit" onclick="preguntaAprobacion(event)" class="waves-effect cyan darken-1 btn center-aling">
                                    <i class="material-icons right">done</i>
                                    Aprobar aval
                                </button>
                            @else
                                <button type="submit" class="waves-effect cyan darken-1 btn center-aling" disabled>
                                    <i class="material-icons right">done</i>
                                    ya ha sido avalada
                                </button>
                            @endif
                    @endif
                @endif
            </form>
    </div>
</div>
