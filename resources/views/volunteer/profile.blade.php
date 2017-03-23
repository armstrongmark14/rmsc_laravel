@extends('layouts.volunteer-page')

@section('content')

    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                Profile: {{ $volunteer->first_name }}
                <span class="align-right">
                    <button>Log Out</button>
                </span>
            </div>
            <div class="panel-body">
                <button class="btn btn-success">Clock In</button>
                <button class="btn btn-warning">View Timesheets</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>

@endsection