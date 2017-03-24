@extends('layouts.volunteer-page')

@section('content')

    @include('templates.errors.login-message')

    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">RMSC Admin</div>
            <div class="panel-body">

                    {!! Form::model($volunteer, ['method' => 'POST', 'action' => 'Admin\AdminController@updateVolunteer']) !!}

                        {{-- This section will hold special hidden values we want to use later updating forms --}}
                        {!! Form::hidden('id', $volunteer->id) !!}
                        {!! Form::hidden('note_id', $volunteer->note->id) !!}
                        {!! Form::hidden('skill_id', $volunteer->skill->id) !!}


                        <div class="col-lg-6">
                            <table class="table borderless">
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
                            <table class="table">
                                <tr>
                                    <td>
                                        {!! Form::label('badge', 'Badge Number:') !!}
                                        {!! Form::number('badge', null, ['id' => 'badge', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label('type', 'Type:') !!}
                                        {!! Form::select('type', $types, $volunteer->type_id, ['class' =>'form-control']) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label('department', 'Department:') !!}
                                        {!! Form::select('department', $departments, $volunteer->department_id, ['class' =>'form-control']) !!}
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
                                        {!! Form::label('skill', 'Skills:') !!}
                                        {!! Form::textarea('skill', $volunteer->skill->value, ['id' => 'skill', 'class' => 'form-control', 'autocomplete' => 'off', 'size' => '30x2']) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label('note', 'Notes:') !!}
                                        {!! Form::textarea('note', $volunteer->note->value, ['id' => 'note', 'class' => 'form-control', 'autocomplete' => 'off', 'size' => '30x2']) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label('image', 'Photo:') !!}
                                        {!! Form::file('image', null, ['id' => 'image', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label('background', 'Background:') !!}
                                        {!! Form::checkbox('background', null, ['id' => 'background', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label('edit_timesheets', 'Can Edit Timesheets:') !!}
                                        {!! Form::checkbox('edit_timesheets', null, ['id' => 'edit_timesheets', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                                    </td>
                                </tr>
                            </table>


                        </div>

                        <div class="form-group text-center">
                            {!! Form::submit('Update Volunteer', ['class' => 'btn btn-success']) !!}
                        </div>



                    {{ Form::close() }}
                </table>
            </div>
        </div>
    </div>

@endsection