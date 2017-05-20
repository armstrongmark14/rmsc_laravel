@extends('layouts.volunteer-page')

@section('content')

    @include('templates.admin.side-navigation')

    @include('templates.errors.error-messages')


    <div class="col-md-4 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                Change Password for: {{ Auth::user()->name }}
            </div>
            <div class="panel-body">

                <div class="form-group col-xs-8 col-xs-offset-2">

                    {!! Form::open(['method' => 'POST', 'action' => 'Admin\AdminController@changePassword']) !!}

                        {{ Form::hidden('user_id', Auth::user()->id) }}

                        {!! Form::label('old_password', 'Old Password:') !!}
                        {!! Form::password('old_password', ['id' => 'old_password', 'class' => 'form-control', 'autocomplete' => 'off', 'autofocus' => 'autofocus']) !!}

                        <br>

                        {!! Form::label('new_password', 'New Password:') !!}
                        {!! Form::password('new_password', ['id' => 'new_password', 'class' => 'form-control', 'autocomplete' => 'off']) !!}

                        <br>

                        {!! Form::label('confirm_password', 'Confirm New Password:') !!}
                        {!! Form::password('confirm_password', ['id' => 'confirm_password', 'class' => 'form-control', 'autocomplete' => 'off']) !!}

                        <br>

                        <div class="form-group text-center">
                            {!! Form::submit('Change Password', ['class' => 'btn btn-success']) !!}
                        </div>

                    {{ Form::close() }}

                </div>

            </div>
        </div>
    </div>

@endsection