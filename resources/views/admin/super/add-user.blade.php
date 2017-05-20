@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.error-messages')

    @include('templates.admin.side-navigation')

    <div class="col-md-4 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                Add User
            </div>
            <div class="panel-body">

                <div class="form-group col-xs-8 col-xs-offset-2">
                    {!! Form::open(['method' => 'POST', 'action' => 'Admin\SuperAdminController@addUser']) !!}

                    {!! Form::label('name', 'Username:') !!}
                    {!! Form::text('name', null, ['id' => 'name', 'class' => 'form-control', 'autocomplete' => 'off', 'autofocus' => 'autofocus']) !!}

                    <br>

                    {!! Form::label('password', 'Password:') !!}
                    {!! Form::password('password', ['id' => 'password', 'class' => 'form-control', 'autocomplete' => 'off']) !!}

                    <br>

                    {!! Form::label('permission', 'Permission Level:') !!}
                    {!! Form::select('permission', $permissions, 1, ['class' =>'form-control']) !!}

                    <br>

                    <div class="form-group text-center">
                        {!! Form::submit('Add User', ['class' => 'btn btn-success']) !!}
                    </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection