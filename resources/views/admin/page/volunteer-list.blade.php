@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.error-messages')

    @include('templates.admin.side-navigation')

    <div class="col-md-10">
        <div class="panel panel-default">

            <div class="panel-heading">RMSC Volunteer List</div>


            <div class="panel-body">
                @include('templates.admin.volunteer-table')
            </div>
        </div>
    </div>

@endsection