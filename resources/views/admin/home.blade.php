@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.login-message')

    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">RMSC Admin</div>
            <div class="panel-body">

                <a href="{{ route('admin-volunteer-list') }}">
                    <button class="btn btn-primary">
                        Volunteer List
                    </button>
                </a>

                <a href="{{ route('volunteers-here') }}">
                    <button class="btn btn-primary">
                        Currently Here
                    </button>
                </a>

            </div>
        </div>
    </div>

@endsection