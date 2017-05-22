@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.error-messages')

    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="profile-name">
                    Edit timesheet for: {{ $volunteer->first_name }} {{ $volunteer->last_name }}
                </span>
                <span class="align-right">
                    <a href="{{ route('volunteer-page') }}">
                        <button id="vol-back-btn" class="btn btn-primary"><i class="fa fa-user"></i> Profile</button>
                    </a>
                </span>
            </div>
            <div class="panel-body">
                {{-- This will be the form for editing the timesheet with the ID that we entered up top --}}

                {!! Form::model($timesheet, ['method' => 'POST', 'action' => 'Volunteer\TimesheetController@updateTimesheet']) !!}

                {!! Form::hidden('id') !!}
                {!! Form::hidden('volunteerID', $volunteer->id) !!}

                @include('templates.time.edit-timesheet-table')

                <div class="form-group text-center">
                    {!! Form::submit('Update Timesheet', ['class' => 'btn btn-success']) !!}
                </div>



                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection