<div class="mailbox-view-header">
    <div class="left">
        <div class="left">

            <span class="mailbox-title">{{$articulationStage->code}} - {{$articulationStage->name}}
            @can('update', $articulationStage)
                <a href="{{route('articulation-stage.edit', $articulationStage)}}" class="orange-text text-darken-2 pointer tooltipped" data-position="right" data-tooltip="editar {{__('articulation-stage')}}"><i class="tiny material-icons">edit</i></a></span>
            @endcan
            <span class="mailbox-title">{{__('Node')}} {{$articulationStage->present()->articulationStageNode()}}</span>
            <span class="mailbox-author">{{$articulationStage->present()->articulationStageInterlocutorTalent()}} ({{__('Interlocutory talent')}})
                @can('update', $articulationStage)
                    <a href="{{ route('articulation-stage.changeinterlocutor', $articulationStage) }}" class="orange-text text-darken-2 pointer tooltipped" data-position="right" data-tooltip="cambiar {{__('Interlocutory talent')}}"><i class="tiny material-icons">edit</i></a>
                @endcan
            </span>
        </div>
    </div>
    <div class="right mailbox-buttons">


        @if((session()->has('login_role') && session()->get('login_role') === App\User::IsArticulador()) && $articulationStage->articulations->count() > 0)

            <a href="" class="waves-effect waves-grey btn-flat m-t-xs">Descargar</a>
            <a href="" class="waves-effect waves-orange btn-flat m-t-xs">Cerrar</a>
        @endif

        @if(auth()->user()->can('delete', $articulationStage))
            <a class="waves-effect waves-red btn-flat m-t-xs">Eliminar</a>
        @endif
    </div>
</div>
