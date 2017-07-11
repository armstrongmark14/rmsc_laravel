@if( Session::has('login-status'))
    <div class="alert alert-danger col-sm-6 col-sm-offset-3">
        {{ Session::get('login-status') }}
    </div>
@endif

@if( Session::has('volunteer-success'))
    <div class="alert alert-success col-md-8 col-md-offset-2">
        {{ Session::get('volunteer-success') }}
    </div>
@endif

@if( Session::has('admin-error'))
    <div class="alert alert-danger col-md-8 col-md-offset-1">
        {{ Session::get('admin-error') }}
    </div>
@endif

@if( Session::has('admin-success'))
    <div class="alert alert-success col-md-8 col-md-offset-1">
        {{ Session::get('admin-success') }}
    </div>
@endif

@if( Session::has('timeclock'))
    <div class="alert alert-info col-sm-6 col-sm-offset-3 disappear">
        {{ Session::get('timeclock') }}
    </div>
    <script>
        $('.disappear').delay(7000).queue(function(){
            $(this).addClass("hidden");
        });
    </script>
@endif

@if (count($errors) > 0)

    {{-- Checking if the page is admin page or not
         and generating the right error width
     --}}
    @if(Request::is('admin/*'))
        <div class="alert alert-danger col-md-8 col-lg-offset-1">
    @else
        <div class="alert alert-danger col-md-10 col-lg-offset-1">
    @endif

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif