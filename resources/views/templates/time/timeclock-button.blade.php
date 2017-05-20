@if (! $openTimesheet[0])
    <a href="{{ route('clock-in') }}">
        <button class="vol-profile-btn btn btn-success"><i class="fa fa-clock-o"></i> Clock In</button>
    </a>
@else
    <a href="{{ route('clock-out') }}">
        <button class="vol-profile-btn btn btn-danger"><i class="fa fa-clock-o"></i> Clock Out</button>
    </a>
@endif