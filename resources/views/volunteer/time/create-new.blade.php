@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.error-messages')

    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="profile-name">
                    Create timesheet for: {{ $volunteer->first_name }} {{ $volunteer->last_name }}
                </span>
                <span class="align-right">
                    <a href="{{ route('volunteer-page') }}">
                        <button id="vol-back-btn" class="btn btn-primary"><i class="fa fa-user"></i> Profile</button>
                    </a>
                </span>
            </div>
            <div class="panel-body">
                {{-- This will be the form for editing the timesheet with the ID that we entered up top --}}

                {!! Form::open(['method' => 'POST', 'action' => 'Volunteer\TimesheetController@createTimesheet']) !!}

                {!! Form::hidden('id') !!}
                {!! Form::hidden('volunteerID', $volunteer->id) !!}

                <table class="table table-bordered table-striped">
                <tr>
                    <td>
                        {!! Form::label('date', 'Date:') !!}
                        {!! Form::text('date', substr($date, 0, 10), ['id' => 'in', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </td>
                    <td>
                        {!! Form::label('in', 'Time in:') !!}
                        {!! Form::text('in', substr($date, 11, 2) . ':00:00', ['id' => 'in', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </td>
                    <td>
                        {!! Form::label('out', 'Time out:') !!}
                        {!! Form::text('out', substr($date, 11, 2) + 1 . ':00:00', ['id' => 'out', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                    </td>
                </tr>
                </table>

                <div class="form-group text-center">
                    {!! Form::submit('Create Timesheet', ['class' => 'btn btn-success']) !!}
                </div>



                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection