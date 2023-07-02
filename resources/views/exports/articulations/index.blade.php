<table>
    <thead>
        <tr>
            <th>
                {{__('Node')}}
            </th>
            <th>
                {{__('Code articulation')}}
            </th>
            <th>
                {{__('Name articulation')}}
            </th>

            <th>
                {{__('Phase')}} {{__('articulation')}}
            </th>
            <th>
                {{ __('Code articulation-stage') }}
            </th>
            <th>
                {{ __('Name articulation-stage') }}
            </th>
            <th>
                {{__('Status')}} {{__('articulation-stage')}}
            </th>
            <th>
                {{__('ArticulationStage Type')}}
            </th>
            <th>
                Código información {{__('ArticulationStage Type')}}
            </th>
            <th>
                Nombre información {{__('ArticulationStage Type')}}
            </th>
            <th>
                {{__('Description')}}
            </th>
            <th>
                {{__('articulation-subtype')}}
            </th>
            <th>
                {{__('articulation-type')}}
            </th>
            <th>
                {{__('Scope')}}
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
                {{ __('Participants talents') }}
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
                {{$articulationStage->articulation_code}}
            </td>
            <td>
                {{$articulationStage->articulation_name}}
            </td>
            <td>
                {{$articulationStage->fase}}
            </td>
            <td>
                {{$articulationStage->code}}
            </td>
            <td>
                {{$articulationStage->name}}
            </td>
            <td>
                {{$articulationStage->present()->articulationStageStatus()}}
            </td>
            <td>
                {{$articulationStage->articulation_state_type}}
            </td>
            <td>
                {{$articulationStage->codigo_proyecto}}
            </td>
            <td>
                {{$articulationStage->nombre_proyecto}}
            </td>
            <td>
                {{$articulationStage->articulation_description}}
            </td>
            <td>
                {{$articulationStage->articulation_subtype}}
            </td>
            <td>
                {{$articulationStage->articulation_type}}
            </td>
            <td>
                {{$articulationStage->scope}}
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
                {{$articulationStage->participants}}
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
