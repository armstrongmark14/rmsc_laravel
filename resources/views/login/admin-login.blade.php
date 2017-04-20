@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.error-messages')

    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">Volunteer Login</div>
            <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'action' => 'Admin\LoginController@loginCheck']) !!}

                <div class="form-group col-xs-8 col-xs-offset-2">
                    {!! Form::label('username', 'User Name:') !!}
                    {!! Form::text('username', null, ['id' => 'username', 'class' => 'form-control', 'autocomplete' => 'off', 'autofocus' => 'autofocus']) !!}
                    <br>
                    {!! Form::label('password', 'Password:') !!}
                    {!! Form::password('password', ['id' => 'password', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                    <br>
                    <div class="form-group text-center">
                        {!! Form::submit('Admin Login', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>

@endsection