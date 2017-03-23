@extends('layouts.volunteer-page')

@section('content')

    @if( Session::has('login-status'))
        <div class="alert alert-danger col-sm-6 col-sm-offset-3">
            {{ Session::get('login-status') }}
        </div>
    @endif

    @if( Session::has('timeclock'))
        <div class="alert alert-info col-sm-4 col-sm-offset-4 disappear">
            {{ Session::get('timeclock') }}
        </div>
        <script>$('.disappear').delay(7000).queue(function(){
                $(this).addClass("hidden");
            });</script>
    @endif


    <div id="actions"></div>

    <br>


    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">Volunteer Login</div>
            <div class="panel-body">
                {!! Form::open(['method' => 'POST', 'action' => 'Volunteer\LoginController@volunteer']) !!}
                <div class="form-group col-xs-8 col-xs-offset-2">
                    {!! Form::label('badge', 'Badge Number:') !!}
                    {!! Form::number('badge', null, ['id' => 'loginBadge', 'class' => 'form-control', 'autocomplete' => 'off', 'autofocus' => 'autofocus']) !!}
                    <br>
                    <div class="form-group text-center">
                        {!! Form::submit('Volunteer Login', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
    </div>
    </div>

@endsection