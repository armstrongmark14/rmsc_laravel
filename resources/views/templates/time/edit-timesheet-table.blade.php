<table class="table table-striped table-bordered">
    <tr>
        <th>{{ substr($timesheet->in, 0, 10) }}</th>
        <th>{{ substr($timesheet->in, 11, 18) }}</th>
        <th>{{ substr($timesheet->displayOut(), 11, 18) }}</th>
        <th>{{ $timesheet->hours() }}</th>
        <th>{{$timesheet->volunteer->first_name }} {{ $timesheet->volunteer->last_name }}</th>
    </tr>
    <tr>
        <td>
            {!! Form::label('date', 'Date:') !!}
            {!! Form::text('date', substr($timesheet->in, 0, 10), ['id' => 'in', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
        </td>
        <td>
            {!! Form::label('in', 'Time in:') !!}
            {!! Form::text('in', substr($timesheet->in, 11, 18), ['id' => 'in', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
        </td>
        <td>
            {!! Form::label('out', 'Time out:') !!}
            {!! Form::text('out', substr($timesheet->out, 11, 18), ['id' => 'out', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
        </td>
    </tr>
</table>