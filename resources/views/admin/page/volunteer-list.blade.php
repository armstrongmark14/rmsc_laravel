@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.error-messages')

    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">

            <table class="table table-sm">
                <tr>
                    <td>
                        <a href="{{ route('admin-home') }}">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            Home
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin-volunteer-list') }}">
                            <i class="fa fa-list" aria-hidden="true"></i>
                            Volunteer List
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin-create-volunteer') }}">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            Add Volunteer
                        </a>
                    </td>
                </tr>
            </table>


            <div class="panel-body">
                @include('templates.admin.volunteer-table')
            </div>
        </div>
    </div>

@endsection