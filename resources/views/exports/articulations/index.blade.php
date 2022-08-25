<table>
    <thead>
        <tr>
            <th>
                {{__('Node')}}
            </th>
            <th>
                {{__('ArticulationStage Type')}}
            </th>
            <th>
                {{__('Code ArticulationStage')}}
            </th>
            <th>
                {{__('Name ArticulationStage')}}
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
                {{$articulationStage->present()->accompanimentNode()}}
            </td>
            <td>
                {{$articulationStage->present()->accompanimentableType()}}
            </td>
            <td>
                {{$articulationStage->present()->accompanimentCode()}}
            </td>
            <td>
                {{$articulationStage->present()->accompanimentName()}}
            </td>
            <td>
                {{$articulationStage->present()->accompanimentables()}}
            </td>
            <td>
                {{$articulationStage->present()->accompanimentDescription()}}
            </td>
            <td>
                {{$articulationStage->present()->accompanimentScope()}}
            </td>
            <td>
                {{$articulationStage->present()->accompanimentStatus()}}
            </td>
            <td>
                {{$articulationStage->present()->accompanimentStartDate()}}
            </td>
            <td>
                {{$articulationStage->present()->accompanimentEndDate()}}
            </td>
            <td>
                {{$articulationStage->present()->accompanimentCreatedDate()}}
            </td>
            <td>
                {{$articulationStage->present()->accompanimentInterlocutorTalent()}}
            </td>
            <td>
                {{$articulationStage->present()->accompanimentBy()}}
            </td>
            <td>
                {{$articulationStage->articulations_count}}
            </td>
            <td>
                {{$articulationStage->present()->accompanimentArticulation()}}
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
