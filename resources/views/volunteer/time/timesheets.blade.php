@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.error-messages')

    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">

            <div class="panel-heading">
                <span class="profile-name">
                    Times: {{ $volunteer->first_name }}
                </span>

                <a href="{{ route('volunteer-page') }}">
                    <button id="vol-back-btn" class="btn btn-success"><i class="fa fa-user"></i> Profile</button>
                </a>
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