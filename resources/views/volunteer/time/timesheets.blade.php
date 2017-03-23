@extends('layouts.volunteer-page')

@section('content')

    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="profile-name">
                    Timesheets: {{ $volunteer->first_name }}
                </span>
                <span class="align-right">
                    <a href="{{ route('home') }}">
                        <button>Log Out</button>
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