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
                        <button>Log Out</button>
                    </a>
                </span>
            </div>
            <div class="panel-body">

                @if (! $openTimesheet[0])
                    <a href="{{ route('clock-in') }}">
                        <button class="btn btn-success">Clock In</button>
                    </a>
                @else
                    <a href="{{ route('clock-out') }}">
                        <button class="btn btn-danger">Clock Out</button>
                    </a>
                @endif

                <a href="{{ route('volunteer-timesheets') }}">
                    <button class="btn btn-warning">View Timesheets</button>
                </a>

            </div>
        </div>
        {{ Form::close() }}
    </div>

@endsection