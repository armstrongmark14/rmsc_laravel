@extends('layouts.volunteer-page')

@section('content')

    @include('templates.admin.side-navigation')

    @include('templates.errors.error-messages')


    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Users Logged in Between <b>{{$start}} - {{$end}}</b></h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Recent Login</th>
                        <th>Badge #</th>
                        <th>Hours Worked</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Department</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>

                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->login }}</td>
                            <td>{{ $user->badge }}</td>
                            <td>{{ $user->hours_worked }}</td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->department }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>

@endsection