<table class="table table-striped table-bordered">
    <tr>
        <th>Date</th>
        <th>Time In</th>
        <th>Time Out</th>
        <th>Hours</th>
    </tr>
    {{-- This will include as many timesheet-rows as we need --}}
    @foreach ($timesheets as $timesheet)
        <tr>
            <td>{{ substr($timesheet->in, 0, 10) }}</td>
            <td>{{ substr($timesheet->in, 10, 18) }}</td>
            <td>{{ substr($timesheet->out, 10, 18) }}</td>
            <td>{{ $timesheet->hours() }}</td>
        </tr>
    @endforeach

</table>