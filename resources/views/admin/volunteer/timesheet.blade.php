@extends('layouts.volunteer-page')

@section('content')

    @include('templates.admin.side-navigation')

    @include('templates.errors.error-messages')

    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="profile-name">
                    Timesheets: {{ $volunteer->first_name }} {{ $volunteer->last_name }}
                </span>
                <span class="align-right">
                    <a href="{{ route('volunteer-profile', ['id' => $volunteer->id]) }}">
                        <button id="vol-back-btn" class="btn btn-primary">Back to Profile</button>
                    </a>
                </span>
            </div>
            <div class="panel-heading">
                <span class="total-hours">Total Hours: {{ $volunteer->totalHours() }}</span>

            </div>
            <div class="panel-body">
                {{-- Including the timesheet table template, already have the variable $timesheets here --}}
                @include('templates.time.timesheet-table')
            </div>
        </div>
    </div>

@endsection