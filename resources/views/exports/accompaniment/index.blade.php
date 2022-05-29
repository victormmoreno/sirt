<table>
    <thead>
        <tr>
            <th>
                {{__('Node')}}
            </th>
            <th>
                {{__('Accompaniment Type')}}
            </th>
            <th>
                {{__('Code Accompaniment')}}
            </th>
            <th>
                {{__('Name Accompaniment')}}
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
        @forelse($accompaniments as $accompaniment)
        <tr>
            <td>
                {{$accompaniment->present()->accompanimentNode()}}
            </td>
            <td>
                {{$accompaniment->present()->accompanimentableType()}}
            </td>
            <td>
                {{$accompaniment->present()->accompanimentCode()}}
            </td>
            <td>
                {{$accompaniment->present()->accompanimentName()}}
            </td>
            <td>
                {{$accompaniment->present()->accompanimentables()}}
            </td>
            <td>
                {{$accompaniment->present()->accompanimentDescription()}}
            </td>
            <td>
                {{$accompaniment->present()->accompanimentScope()}}
            </td>
            <td>
                {{$accompaniment->present()->accompanimentStatus()}}
            </td>
            <td>
                {{$accompaniment->present()->accompanimentStartDate()}}
            </td>
            <td>
                {{$accompaniment->present()->accompanimentEndDate()}}
            </td>
            <td>
                {{$accompaniment->present()->accompanimentCreatedDate()}}
            </td>
            <td>
                {{$accompaniment->present()->accompanimentInterlocutorTalent()}}
            </td>
            <td>
                {{$accompaniment->present()->accompanimentBy()}}
            </td>
            <td>
                {{$accompaniment->articulations_count}}
            </td>
            <td>
                {{$accompaniment->present()->accompanimentArticulation()}}
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
