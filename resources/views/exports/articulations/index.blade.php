<table>
    <thead>
        <tr>
            <th>
                {{__('Node')}}
            </th>
            <th>
                {{__('articulation-stage Type')}}
            </th>
            <th>
                {{__('Code articulation-stage')}}
            </th>
            <th>
                {{__('Name articulation-stage')}}
            </th>
            <th>
                {{ __('Project') }}
            </th>
            <th>
                {{__('Description')}}
            </th>
            <th>
                {{__('Scope')}}
            </th>
            <th>
                {{__('Status')}}
            </th>
            <th>
                {{__('Start Date')}}
            </th>
            <th>
                {{__('End Date')}}
            </th>
            <th>
                {{__('Created_at')}}
            </th>
            <th>
                {{__('Interlocutory talent')}}
            </th>
            <th>
                {{ __('Articulations') }}
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse($articulationStages as $articulationStage)
        <tr>
            <td>
                {{$articulationStage->nodo}}
            </td>
            <td>
                {{$articulationStage->articulation_type}}
            </td>
            <td>
                {{$articulationStage->code}}
            </td>
            <td>
                {{$articulationStage->name}}
            </td>
            <td>
                {{$articulationStage->codigo_proyecto}} - {{$articulationStage->nombre_proyecto}}
            </td>
            <td>
                {{$articulationStage->present()->articulationStageDescription()}}
            </td>
            <td>
                {{$articulationStage->present()->articulationStageScope()}}
            </td>
            <td>
                {{$articulationStage->present()->articulationStageStatus()}}
            </td>
            <td>
                {{$articulationStage->present()->articulationStageStartDate()}}
            </td>
            <td>
                {{$articulationStage->present()->articulationStageEndDate()}}
            </td>
            <td>
                {{$articulationStage->present()->articulationStageCreatedDate()}}
            </td>
            <td>
                {{$articulationStage->documento}} - {{$articulationStage->nombres}} {{$articulationStage->apellidos}}
            </td>
            <td>
                {{$articulationStage->present()->articulationStageArticulation()}}
            </td>
        </tr>
        @empty
        <tr>
            <td>
                No hay información disponible
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
