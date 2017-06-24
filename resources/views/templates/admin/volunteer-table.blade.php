<table id="volunteer-table" class="table table-striped table-bordered">
    <tr>
        {{--<th>Picture</th>--}}
        <th>Badge #</th>
        <th>Name</th>
        <th>Department</th>
        <th>Type</th>
        {{--<th>Hours</th>--}}
    </tr>

    @foreach ($volunteers as $volunteer)
        <tr class="vol-row">
            {{--<td><img src="/images/volunteers/{{ $volunteer->filename }}" height="50px" width="50px"></td>--}}
            <td>{{ $volunteer->badge }}</td>
            <td><a href="{{ route('volunteer-profile', ['id' => $volunteer->id]) }}">{{ $volunteer->first_name . ' ' . $volunteer->last_name }}</a></td>
            <td>{{ $volunteer->department }}</td>
            <td>{{ $volunteer->type }}</td>
            {{--<td>{{ $volunteer->totalHours() }}</td>--}}
        </tr>
    @endforeach

</table>