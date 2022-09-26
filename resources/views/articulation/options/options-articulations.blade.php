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
            @if($articulationStage->status == \App\Models\ArticulationStage::STATUS_OPEN)
            <a href="{{route('articulations.create', $articulationStage->id )}}"
               class="waves-effect waves-orange btn orange m-t-xs">{{ __('New Articulation') }}</a>
            @endif
        @endcan
    </div>
</div>
