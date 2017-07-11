@extends('layouts.volunteer-page')

@section('content')

    @include('templates.admin.side-navigation')

    @include('templates.errors.error-messages')

    @if (isset($volunteer))
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading volunteer-quick-profile">
                    <table class="pull-right">
                        <tr><td><b>Phone:</b> {{ $volunteer->phone }}</td><td><div class="col-md-1"></div></td></tr>
                        <tr><td><b>Email:</b> {{ $volunteer->email }}</td></tr>
                        <tr><td><b>Emergency Contact:</b> {{ $volunteer->emergency_contact }}</td></tr>
                        <tr><td><b>Emergency Phone:</b> {{ $volunteer->emergency_phone }}</td></tr>
                    </table>

                    <table class="inline">
                        <tr class="col-md-12">
                            <td><div class="col-md-1"></div></td>
                            <td><img src="https://rmscvol.com/images/volunteers/{{ $volunteer->photo->filename }}" height="150px" width="150px"></td>
                            <td><div class="col-md-1"></div></td>
                            <td>
                                <table>
                                    <tr><td><b>Badge:</b> {{ $volunteer->badge }}</td></tr>
                                    <tr><td><b>Name:</b> {{ $volunteer->first_name . ' ' . $volunteer->last_name }}</td></tr>
                                    <tr><td><b>Department:</b> {{ $volunteer->department->name }}</td></tr>
                                    <tr><td><b>Type:</b> {{ $volunteer->type->name }}</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="panel-body">

                        {{-- Only want to display these links if this is a volunteer profile --}}
                        @if (isset($volunteer))

                        <script>
                            // Function for showing and hiding the edit section on the volunteer profile
                            $(document).ready(function() {

                                editPart = $('.edit-section');
                                link = $('#show-profile');
                                hidden = true;
                                editPart.hide();

                                link.click(function() {

                                   if (hidden) {
                                       editPart.show();
                                       link.removeClass("btn-primary").addClass("btn-warning");
                                       link.html("Click to Hide Dropdown");
                                       hidden = false;
                                   } else {
                                       editPart.hide();
                                       link.removeClass("btn-warning").addClass("btn-primary");
                                       link.html("Click to Edit Information");
                                       hidden = true;
                                   }
                                });



                            });
                        </script>
                        <style>
                            .volunteer-quick-profile {
                                font-size: 20px;
                            }
                            a {
                                cursor: pointer;
                            }
                        </style>


                            <a class="col-md-3" href="/admin/create/timesheet/{{ $volunteer->id }}">
                                <button class="btn btn-success">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    Create New Timesheet
                                </button>
                            </a>

                            <a class="col-md-3" href="{{ route('admin-volunteer-timesheet', ['id' => $volunteer->id]) }}">
                                <button class="btn btn-primary">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    Timesheet
                                </button>
                            </a>


                            @if (Auth::user()->isSuperAdmin())
                                {{--<a class="col-md-3" href="{{ route('volunteer-delete', ['id' => $volunteer->id]) }}">--}}
                                    {{--<button class="btn btn-warning">--}}
                                        {{--<i class="fa fa-id-badge" aria-hidden="true"></i>--}}
                                        {{--Change Badge #--}}
                                    {{--</button>--}}
                                {{--</a>--}}

                                <a class="col-md-3" href="{{ route('volunteer-delete', ['id' => $volunteer->id]) }}">
                                    <button class="btn btn-danger">
                                        <i class="fa fa-remove" aria-hidden="true"></i>
                                        Delete Volunteer
                                    </button>
                                </a>


                            @endif

                        @endif
                </div>
            </div>
        </div>

    @endif


    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                RMSC - @if(isset($volunteer)) Update Volulnteer @else Add Volunteer @endif
                <button id="show-profile" class="btn btn-primary">Click to Edit Information</button>


            </div>
            <div class="panel-body edit-section">

                @include ('templates.admin.volunteer-form')

            </div>
        </div>
    </div>




@endsection