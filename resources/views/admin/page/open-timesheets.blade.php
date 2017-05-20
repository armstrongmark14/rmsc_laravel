@extends('layouts.volunteer-page')

@section('content')

    @include('templates.admin.side-navigation')

    <div class="col-md-10">
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