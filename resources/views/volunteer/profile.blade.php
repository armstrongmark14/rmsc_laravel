@extends('layouts.volunteer-page')

@section('content')

    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="profile-name">
                    Profile: {{ $volunteer->first_name }}
                </span>
                <span class="align-right">
                    <a href="{{ route('home') }}">
                        <button id="vol-logout-btn" class="btn btn-danger"><i class="fa fa-sign-out"></i> Log Out</button>
                    </a>
                </span>
            </div>
            <div class="vol-profile panel-body">

                @include('templates.time.timeclock-button')

                <br><br>

                <a href="{{ route('volunteer-timesheets') }}">
                    <button class="vol-profile-btn btn btn-primary"><i class="fa fa-id-card"></i> View Timesheets</button>
                </a>

                @if($volunteer->edit_time == 1)
                    <br><br>
                    <a href="{{ route('volunteer-create-timesheet') }}">
                        <button class="vol-profile-btn btn btn-warning"><i class="fa fa-hourglass"></i> Log Hours</button>
                    </a>
                @endif

            </div>
        </div>
        {{ Form::close() }}
    </div>

@endsection