@extends('layouts.volunteer-page')

@section('content')

    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="profile-name">
                    Edit timesheet for: {{ $volunteer->first_name }} {{ $volunteer->last_name }}
                </span>
                <span class="align-right">
                    <a href="{{ route('volunteer-profile', ['id' => $volunteer->id]) }}">
                        <button class="btn btn-primary">Back to Profile</button>
                    </a>
                </span>
            </div>
            <div class="panel-body">
                {{-- This will be the form for editing the timesheet with the ID that we entered up top --}}

                {!! Form::model($timesheet, ['method' => 'POST', 'action' => 'Admin\AdminController@updateTimesheet']) !!}

                {!! Form::hidden('id') !!}
                {!! Form::hidden('volunteerID', $volunteer->id) !!}

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




                <div class="form-group text-center">
                    {!! Form::submit('Update Timesheet', ['class' => 'btn btn-success']) !!}
                </div>



                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection