@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.error-messages')

    @include('templates.admin.side-navigation')

    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="profile-name">
                    Edit timesheet for: {{ $volunteer->first_name }} {{ $volunteer->last_name }}
                </span>
                <span class="align-right">
                    <a href="{{ route('volunteer-profile', ['id' => $volunteer->id]) }}">
                        <button id="vol-back-btn" class="btn btn-primary">Back to Profile</button>
                    </a>
                </span>
            </div>
            <div class="panel-body">
                {{-- This will be the form for editing the timesheet with the ID that we entered up top --}}

                {!! Form::model($timesheet, ['method' => 'POST', 'action' => 'Admin\AdminController@updateTimesheet']) !!}

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