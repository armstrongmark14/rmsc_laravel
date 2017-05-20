<div class="col-md-2">
    <div class="container-fluid navbar-left">
        <div class="row">
            <ul class="nav nav-sidebar">
                <li><a href="{{ route('admin-home') }}"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="{{ route('admin-volunteer-list') }}"><i class="fa fa-list"></i> Volunteer List</a></li>
                <li><a href="{{ route('volunteers-here') }}"><i class="fa fa-calendar-check-o"></i> Currently Here</a></li>
                <li><a href="{{ route('open-timesheets') }}"><i class="fa fa-exchange"></i> Open Timesheets</a></li>
                <li>&nbsp;</li>
                <li><a href="{{ route('admin-create-volunteer') }}"><i class="fa fa-plus-square"></i> Add Volunteer</a></li>
                <li>&nbsp;</li>
                <li><a href="{{ route('total-hours-chart') }}"><i class="fa fa-bar-chart"></i> Charts</a></li>
                <li>&nbsp;</li>
                <li><a href="{{ route('super-admin-dashboard') }}"><i class="fa fa-dashboard"></i> Admin Dashboard</a></li>
                <li>&nbsp;</li>
                <li><a href="{{ route('admin-add-user') }}"><i class="fa fa-user-plus"></i> Add User</a></li>
                <li><a href="{{ route('manage-users') }}"><i class="fa fa-wrench"></i> Manage Users</a></li>
                <li><a href="{{ route('admin-change-password') }}"><i class="fa fa-unlock"></i> Change Password</a></li>
                <li>&nbsp;</li>
                <li><a href=""><i class="fa fa-search"></i> Old System</a></li>
            </ul>
        </div>
    </div>
</div>