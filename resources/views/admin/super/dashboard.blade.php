@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.error-messages')

    @include('templates.admin.side-navigation')

    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading">Super Admin Dashboard</div>
            <div class="panel-body">

                <div class="col-lg-4">

                    {!! Form::open(['method' => 'POST', 'action' => 'Admin\SuperAdminController@addType']) !!}

                        <div class="form-group col-xs-8 col-xs-offset-2">
                            {!! Form::label('name', 'Add Type:') !!}
                            {!! Form::text('name', null, ['id' => 'name', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                            <br>
                            <div class="form-group text-center">
                                {!! Form::submit('Add Type', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                    {{ Form::close() }}

                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Type</th>
                            <th>Remove</th>
                        </tr>
                        @foreach ($types as $type)
                            <tr>
                                <td>{{ $type->name }}</td>
                                <td><a href="{{ route('remove-type', $type->id) }}">Remove</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>

                <div class="col-lg-4">

                    {!! Form::open(['method' => 'POST', 'action' => 'Admin\SuperAdminController@addDepartment']) !!}

                    <div class="form-group col-xs-8 col-xs-offset-2">
                        {!! Form::label('name', 'Add Department:') !!}
                        {!! Form::text('name', null, ['id' => 'name', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                        <br>
                        <div class="form-group text-center">
                            {!! Form::submit('Add Department', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                    {{ Form::close() }}

                    <table class="table table-sm table-striped table-bordered">
                        <tr>
                            <th>Department</th>
                            <th>Remove</th>
                        </tr>
                        @foreach ($departments as $department)
                            <tr>
                                <td>{{ $department->name }}</td>
                                <td><a href="{{ route('remove-department', $department->id) }}">Remove</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>

                <div class="col-lg-4">

                    {!! Form::open(['method' => 'POST', 'action' => 'Admin\SuperAdminController@addLocation']) !!}

                    <div class="form-group col-xs-8 col-xs-offset-2">
                        {!! Form::label('ip_address', 'Add Location:') !!}
                        {!! Form::text('ip_address', null, ['id' => 'ip_address', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                        <br>
                        <div class="form-group text-center">
                            {!! Form::submit('Add Location', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                    {{ Form::close() }}

                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Type</th>
                            <th>Remove</th>
                        </tr>
                        @foreach ($locations as $location)
                            <tr>
                                <td>{{ $location->ip_address }}</td>
                                <td><a href="{{ route('remove-location', $location->id) }}">Remove</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>


            </div>
        </div>
    </div>

@endsection