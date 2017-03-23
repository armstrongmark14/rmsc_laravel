<table class="table table-striped table-bordered">
    <tr>
        <th>Picture</th>
        <td>Badge #</td>
        <th>Name</th>
        <th>Department</th>
        <th>Hours</th>
    </tr>

    @foreach ($volunteers as $volunteer)
        <tr>
            <td>{{ $volunteer->photo->filename }}</td>
            <td>{{ $volunteer->badge }}</td>
            <td>{{ $volunteer->first_name }} {{ $volunteer->last_name }}</td>
            <td>{{ $volunteer->department->name }}</td>
            <td>{{ $volunteer->totalHours() }}</td>
        </tr>
    @endforeach

</table>