<table class="table table-striped table-bordered">
    <tr>
        <th>Date</th>
        <th>Time In</th>
        <th>Time Out</th>
        <th>Hours</th>

        @if (isset($volunteerPage) && $volunteer->canEditTimesheets())
            <th>Edit</th>
        @endif

        @if(isset($editTimesheets))
            <th>Name</th>
            <th>Edit</th>
            <th>Delete</th>
        @endif
    </tr>
    {{-- This will include as many timesheet-rows as we need --}}
    @foreach ($timesheets as $timesheet)
        <tr>
            <td>{{ substr($timesheet->in, 0, 10) }}</td>
            <td>{{ substr($timesheet->in, 11, 18) }}</td>
            <td>{{ substr($timesheet->displayOut(), 11, 18) }}</td>
            <td>{{ $timesheet->hours() }}</td>

            @if (isset($volunteerPage) && $volunteer->canEditTimesheets())
                <td><a href="{{ route('volunteer-edit-timesheet', $timesheet->id) }}">Edit</a></td>
            @endif

            @if(isset($editTimesheets))
                <td>{{$timesheet->volunteer->first_name }} {{ $timesheet->volunteer->last_name }}</td>
                <td><a href="{{ route('admin-edit-timesheet', $timesheet->id) }}">Edit</a></td>
                <td><a href="{{ route('admin-remove-timesheet', $timesheet->id) }}">Delete</a></td>
            @endif

        </tr>
    @endforeach

</table>