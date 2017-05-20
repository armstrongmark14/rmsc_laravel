@extends('layouts.volunteer-page')

@section('content')

    @include('templates.admin.side-navigation')

    @include('templates.errors.error-messages')


    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                Manage Users
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Username</th>
                        <th>Access Level</th>
                        <th>Update Access</th>
                        <th>Remove User</th>
                    </tr>

                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>
                                {!! Form::model($user, ['method' => 'POST', 'action' => 'Admin\SuperAdminController@changePermissions']) !!}

                                    {{ Form::hidden('user_id', $user->id) }}

                                    {!! Form::select('permission', $permissions, $user->permission->id, ['class' =>'form-control']) !!}
                            </td>
                            <td>
                                    <div class="form-group text-center">
                                        {!! Form::submit('Change Permissions', ['class' => 'btn btn-success']) !!}
                                    </div>

                                {{ Form::close() }}
                            </td>
                            <td>
                                <div class="form-group text-center">
                                    <a href="{{ route('remove-admin-user', $user->id) }}">
                                        <button class="btn btn-danger">Remove User</button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>

@endsection