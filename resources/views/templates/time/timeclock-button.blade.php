@if (! $openTimesheet[0])
    <a id="timeclockButton" href="{{ route('clock-in') }}">
        <button class="vol-profile-btn btn btn-success"><i class="fa fa-clock-o"></i> Clock In</button>
    </a>
@else
    <a id="timeclockButton" href="{{ route('clock-out') }}">
        <button class="vol-profile-btn btn btn-danger"><i class="fa fa-clock-o"></i> Clock Out</button>
    </a>
@endif

<script>
    $('#timeclockButton').click( function() {
        loadingGif($("#profileBody"));
    });

    function loadingGif(div) {
        div.html(
            '<img src="https://rmscvol.com/images/structure/loading-2.gif"><br>Loading...'
        );
    }
</script>