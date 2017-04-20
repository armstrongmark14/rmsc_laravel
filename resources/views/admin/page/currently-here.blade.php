@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.error-messages')

    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">RMSC Admin - Volunteers Currently Here</div>
            <div class="panel-body">
                @include('templates.admin.volunteer-table')
            </div>
        </div>
    </div>

@endsection