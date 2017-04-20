@extends('layouts.volunteer-page')

@section('content')

    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                Open Timesheets
            </div>
            <div class="panel-body">
                {{-- Including the timesheet table template, already have the variable $timesheets here --}}
                @include('templates.time.timesheet-table')
            </div>
        </div>
    </div>

@endsection