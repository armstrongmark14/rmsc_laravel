@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.error-messages')

    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">RMSC Admin - {{ Auth::user()->name }}</div>
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

                <a href="{{ route('open-timesheets') }}">
                    <button class="btn btn-warning">
                        Open Timesheets
                    </button>
                </a>
                @if (Auth::user()->isSuperAdmin())

                    <a href="{{ route('super-admin-dashboard') }}">
                        <button class="btn btn-primary">
                            Super Admin Dashboard
                        </button>
                    </a>
                @endif

            </div>
        </div>
    </div>

@endsection