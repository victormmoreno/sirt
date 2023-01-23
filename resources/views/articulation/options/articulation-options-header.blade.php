<div class="mailbox-view-header">
    <div class="left">
        <div class="left">
            <span class="mailbox-title">{{$articulation->present()->articulationCode()}} - {{$articulation->present()->articulationName()}}
                @can('update', $articulation)
                    <a href="{{route('accompaniments.edit', $articulation)}}" class="primary-text pointer tooltipped" data-position="right" data-tooltip="editar {{__('articulation-stage')}}"><i class="tiny material-icons">edit</i></a>
                @endcan
            </span>
            <span class="mailbox-title">{{__('Node')}} {{$articulation->articulationstage->present()->articulationStageNode()}}</span>
            <span class="mailbox-author">{{$articulation->present()->articulationBy()}} (Articulador)</span>
                @if (Route::currentRouteName() == 'articulation-stage.show')
                    @can('changeTalent', $articulation)
                        <a href="{{ route('articulation-stage.changeinterlocutor', $articulation) }}" class="primary-text pointer tooltipped" data-position="right" data-tooltip="cambiar {{__('Interlocutory talent')}}"><i class="tiny material-icons">edit</i></a>
                    @endcan
                @endif
            </span>
        </div>
    </div>
    <div class="right mailbox-buttons">
            @can('create', App\Models\Articulation::class)
                @include('articulation.form.change-articulation-phase')
            @endcan
    </div>
</div>
