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
                {{__('Created_by')}}
            </th>
            <th>
                {{ __('Count Articulations') }}
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
                {{$articulationStage->present()->articulationStageNode()}}
            </td>
            <td>
                {{$articulationStage->present()->articulationStageableType()}}
            </td>
            <td>
                {{$articulationStage->present()->articulationStageCode()}}
            </td>
            <td>
                {{$articulationStage->present()->articulationStageName()}}
            </td>
            <td>
                {{$articulationStage->present()->articulationStageables()}}
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
                {{$articulationStage->present()->articulationStageInterlocutorTalent()}}
            </td>
            <td>
                {{$articulationStage->present()->articulationStageBy()}}
            </td>
            <td>
                {{$articulationStage->articulations_count}}
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
