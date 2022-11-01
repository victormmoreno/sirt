<div class="mailbox-view-header">
    <div class="left">
        <div class="left">
            <span class="mailbox-title">{{$articulationStage->code}} - {{$articulationStage->name}}
                @if (Route::currentRouteName() == 'articulation-stage.show')
                    @can('update', $articulationStage)
                        <a href="{{route('articulation-stage.edit', $articulationStage)}}" class="orange-text text-darken-2 pointer tooltipped" data-position="right" data-tooltip="editar {{__('articulation-stage')}}"><i class="tiny material-icons">edit</i></a>
                    @endcan
                @endif
            </span>
            <span class="mailbox-title">{{__('Node')}} {{$articulationStage->nodo}}</span>
            <span class="mailbox-author">{{$articulationStage->talent_interlocutor}} ({{__('Interlocutory talent')}})
                @if (Route::currentRouteName() == 'articulation-stage.show')
                    @can('changeTalent', $articulationStage)
                        <a href="{{ route('articulation-stage.changeinterlocutor', $articulationStage) }}" class="orange-text text-darken-2 pointer tooltipped" data-position="right" data-tooltip="cambiar {{__('Interlocutory talent')}}"><i class="tiny material-icons">edit</i></a>
                    @endcan
                @endif
            </span>
        </div>
    </div>
    <div class="right mailbox-buttons">
        @if (Route::currentRouteName() == 'articulation-stage.show')
            @can('create', App\Models\Articulation::class)
                @if($articulationStage->status == \App\Models\ArticulationStage::STATUS_OPEN)
                <a href="{{route('articulations.create', $articulationStage)}}"
                   class="waves-effect waves-orange btn orange m-t-xs">{{ __('New Articulation') }}</a>
                @endif
            @endcan
        @endif
    </div>
</div>
