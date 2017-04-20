@extends('layouts.volunteer-page')

@section('content')

    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="profile-name">
                    Timesheets: {{ $volunteer->first_name }} {{ $volunteer->last_name }}
                </span>
                <span class="total-hours">Total Hours: {{ $volunteer->totalHours() }}</span>
                <span class="align-right">
                    <a href="{{ route('volunteer-profile', ['id' => $volunteer->id]) }}">
                        <button class="btn btn-primary">Back to Profile</button>
                    </a>
                </span>
            </div>
            <div class="panel-body">
                {{-- Including the timesheet table template, already have the variable $timesheets here --}}
                @include('templates.time.timesheet-table')
            </div>
        </div>
    </div>

@endsection