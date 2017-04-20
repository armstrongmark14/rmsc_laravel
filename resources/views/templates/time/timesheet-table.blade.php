<table class="table table-striped table-bordered">
    <tr>
        <th>Date</th>
        <th>Time In</th>
        <th>Time Out</th>
        <th>Hours</th>
        @if(isset($editTimesheets))
            <th>Name</th>
            <td>Edit</td>
        @endif
    </tr>
    {{-- This will include as many timesheet-rows as we need --}}
    @foreach ($timesheets as $timesheet)
        <tr>
            <td>{{ substr($timesheet->in, 0, 10) }}</td>
            <td>{{ substr($timesheet->in, 11, 18) }}</td>
            <td>{{ substr($timesheet->displayOut(), 11, 18) }}</td>
            <td>{{ $timesheet->hours() }}</td>
            @if(isset($editTimesheets))
                <td>{{$timesheet->volunteer->first_name }} {{ $timesheet->volunteer->last_name }}</td>
                <td><a href="{{ route('admin-edit-timesheet', $timesheet->id) }}">Edit</a></td>
            @endif
        </tr>
    @endforeach

</table>