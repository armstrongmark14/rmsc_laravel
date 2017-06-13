@extends('layouts.volunteer-page')

@section('content')

    @include('templates.admin.side-navigation')

    @include('templates.errors.error-messages')

    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading">RMSC - Add Volunteer

                {{-- Only want to display these links if this is a volunteer profile --}}
                @if (isset($volunteer))
                    <a href="/admin/create/timesheet/{{ $volunteer->id }}">
                        <button class="btn btn-success">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                            Create New Timesheet
                        </button>
                    </a>

                    <a href="{{ route('admin-volunteer-timesheet', ['id' => $volunteer->id]) }}">
                        <button class="btn btn-success">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                            Timesheet
                        </button>
                    </a>

                    @if (Auth::user()->isSuperAdmin())
                        <a href="{{ route('volunteer-delete', ['id' => $volunteer->id]) }}">
                            <button class="btn btn-danger">
                                <i class="fa fa-remove" aria-hidden="true"></i>
                                Delete Volunteer
                            </button>
                        </a>
                    @endif

                @endif

            </div>
            <div class="panel-body">

                @include ('templates.admin.volunteer-form')

            </div>
        </div>
    </div>

@endsection