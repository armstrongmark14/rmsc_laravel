@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.error-messages')


    <div class="login-text col-md-10 col-md-offset-1">
        Welcome to the RMSC!<br>Please swipe your badge or enter your badge #.
    </div>


    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">Volunteer Login</div>
            <div class="panel-body">

                {!! Form::open(['method' => 'POST', 'id' => 'loginForm', 'action' => 'Volunteer\LoginController@loginCheck']) !!}

                {!! Form::hidden('ip_address', $_SERVER['REMOTE_ADDR']) !!}

                <div class="form-group col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1">
                    {!! Form::label('badge', 'Badge Number:') !!}
                    {!! Form::number('badge', null, ['id' => 'loginBadge', 'class' => 'form-control', 'autocomplete' => 'off', 'autofocus' => 'autofocus']) !!}
                    <br>
                    <div class="form-group text-center">
                        {!! Form::submit('Login', ['id' => 'vol-login-btn', 'class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>

@endsection