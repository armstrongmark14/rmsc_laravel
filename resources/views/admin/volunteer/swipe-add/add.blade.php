@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.error-messages')

    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="profile-name">
                    Add New Volunteer
                </span>

                <span class="align-right">
                    <a href="{{ route('home') }}">
                        <button id="vol-back-btn" class="btn btn-danger">If you are not creating a new badge, click here to go back</button>
                    </a>
                </span>
            </div>
            <div class="panel-body">

                    {!! Form::open(['method' => 'POST', 'enctype' => 'multipart/form-data', 'action' => 'Admin\AdminController@newBadgeSubmitted']) !!}

                <div class="col-lg-6">
                    <table class="table table-no-border">
                        <tr>
                            <td>
                                {!! Form::label('first_name', 'First Name:') !!}
                                {!! Form::text('first_name', null, ['id' => 'first_name', 'class' => 'form-control', 'autocomplete' => 'off', 'autofocus' => 'autofocus']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::label('last_name', 'Last Name:') !!}
                                {!! Form::text('last_name', null, ['id' => 'last_name', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::label('email', 'Email:') !!}
                                {!! Form::text('email', null, ['id' => 'email', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::label('phone', 'Phone:') !!}
                                {!! Form::text('phone', null, ['id' => 'phone', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::label('address', 'Address:') !!}
                                {!! Form::text('address', null, ['id' => 'address', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::label('city', 'City:') !!}
                                {!! Form::text('city', null, ['id' => 'city', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::label('state', 'State:') !!}
                                {!! Form::text('state', null, ['id' => 'state', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::label('zip', 'Zip Code:') !!}
                                {!! Form::text('zip', null, ['id' => 'zip', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                            </td>
                        </tr>
                    </table>


                </div>
                <div class="col-lg-6">
                    <table class="table table-no-border">
                        <tr>
                            <td>
                                {!! Form::label('badge', 'Badge Number:') !!}
                                {!! Form::number('badge', $badgeValue, ['class' =>'form-control', 'readonly']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::label('type', 'Type:') !!}
                                {!! Form::select('type', $types, isset($volunteer) ? $volunteer->type_id : null, ['class' =>'form-control']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::label('department', 'Department:') !!}
                                {!! Form::select('department', $departments, isset($volunteer) ? $volunteer->department_id : null, ['class' =>'form-control']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::label('supervisor', 'Supervisor:') !!}
                                {!! Form::text('supervisor', null, ['id' => 'supervisor', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::label('emergency_contact', 'Emergency Contact:') !!}
                                {!! Form::text('emergency_contact', null, ['id' => 'emergency_contact', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::label('emergency_phone', 'Emergency Phone:') !!}
                                {!! Form::text('emergency_phone', null, ['id' => 'emergency_phone', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                            </td>
                        </tr>
                    </table>

                    <table class="table table-no-border">
                        <tr>
                            <td>
                                {!! Form::label('username', 'Admin Username:') !!}
                                {!! Form::text('username', null, ['id' => 'username', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::label('password', 'Admin Password:') !!}
                                {!! Form::password('password', ['id' => 'password', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                            </td>
                        </tr>
                    </table>


                </div>

                <div class="form-group text-center">
                    {!! Form::submit('Add Volunteer', ['class' => 'btn btn-success']) !!}
                </div>



                {{ Form::close() }}

            </div>
        </div>
    </div>

@endsection