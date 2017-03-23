<table class="table table-striped table-bordered">
    <tr>
        <th>Date</th>
        <th>Time In</th>
        <th>Time Out</th>
        <th>Hours</th>
    </tr>
    {{-- This will include as many timesheet-rows as we need --}}
    @foreach ($timesheets as $timesheet)
        @include('templates.time.timesheet-row')
    @endforeach

</table>