@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.error-messages')

    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="volunteer-name">
                    Delete: {{ $volunteer->first_name }} {{ $volunteer->last_name }}
                </span>

            </div>
            <div class="panel-body">
                <a href="{{ route('volunteer-profile', ['id' => $volunteer->id]) }}">
                    <button class="btn btn-success">
                        <i class="fa fa-list" aria-hidden="true"></i>
                        Back to profile
                    </button>
                </a>

                <a href="{{ route('volunteer-delete-confirmed', ['id' => $volunteer->id]) }}">
                    <button class="btn btn-danger">
                        <i class="fa fa-remove" aria-hidden="true"></i>
                        Confirm Deletion
                    </button>
                </a>

            </div>
        </div>
    </div>

@endsection