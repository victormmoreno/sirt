<div class="mailbox-view-header">
    <div class="left">
        <div class="left">

            <span class="mailbox-title">{{$accompaniment->code}} - {{$accompaniment->name}}
            @can('update', $accompaniment)
                <a href="{{route('articulation-stage.edit', $accompaniment)}}" class="orange-text text-darken-2 pointer tooltipped" data-position="right" data-tooltip="editar {{__('articulation-stage')}}"><i class="tiny material-icons">edit</i></a></span>
            @endcan
            <span class="mailbox-title">{{__('Node')}} {{$accompaniment->present()->accompanimentNode()}}</span>
            <span class="mailbox-author">{{$accompaniment->present()->accompanimentInterlocutorTalent()}} ({{__('Interlocutory talent')}})
                @can('update', $accompaniment)
                    <a href="{{ route('articulation-stage.changeinterlocutor', $accompaniment) }}" class="orange-text text-darken-2 pointer tooltipped" data-position="right" data-tooltip="cambiar {{__('Interlocutory talent')}}"><i class="tiny material-icons">edit</i></a>
                @endcan
            </span>
        </div>
    </div>
    <div class="right mailbox-buttons">
        @if($accompaniment->articulations->count() > 0 && auth()->user()->can('update', $accompaniment))
            <a href="{{route('articulations.create', $accompaniment )}}" class="waves-effect waves-orange btn orange m-t-xs">{{__('New Articulation')}}</a>
        @elseif(auth()->user()->can('update', $accompaniment))
            <a href="{{route('articulation-stage.requestapproval', [$accompaniment])}}" class="waves-effect waves-orange btn orange m-t-xs">Enviar solicitud de aprobación al talento</a>
        @else
            @include('articulation.options.approval-button')
        @endif

        @if((session()->has('login_role') && session()->get('login_role') === App\User::IsArticulador()) && $accompaniment->articulations->count() > 0)

            <a href="" class="waves-effect waves-grey btn-flat m-t-xs">Descargar</a>
            <a href="" class="waves-effect waves-orange btn-flat m-t-xs">Cerrar</a>
        @endif

        @if($accompaniment->articulations->count() <= 0 && auth()->user()->can('update', $accompaniment))
        <a class="waves-effect waves-red btn-flat m-t-xs">Eliminar</a>
        @endif
    </div>
</div>
