@if( Session::has('login-status'))
    <div class="alert alert-danger col-sm-6 col-sm-offset-3">
        {{ Session::get('login-status') }}
    </div>
@endif