@if( Session::has('login-status'))
    <div class="alert alert-danger col-sm-6 col-sm-offset-3">
        {{ Session::get('login-status') }}
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
    <div class="alert alert-danger col-lg-8 col-lg-offset-2">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif