@if (! $openTimesheet[0])
    <a href="{{ route('clock-in') }}">
        <button class="btn btn-success">Clock In</button>
    </a>
@else
    <a href="{{ route('clock-out') }}">
        <button class="btn btn-danger">Clock Out</button>
    </a>
@endif