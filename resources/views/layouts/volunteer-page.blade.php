<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <!-- FontAwesome icons CDN -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Base jQuery -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <!-- Bootstrap Core JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <title>RMSC - Volunteers</title>

    <style>
        body {
            font-family: Helvetica, sans-serif;
            font-size: 16px;
        }
        .fa {
            font-size: 20px;
        }
        .icon-large {
            font-size: 35px;
        }
        .hidden {
            height: 0px;
            width: 0px;
            display: none;
        }

    </style>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
         <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>
            RMSC Volunteers
            <!-- <a class="navbar-brand" href="/"><img id="logo" src="" height="50px" width="200px"></a> -->
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="navLink">
                    <a href="{{ route('home') }}">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="navText">Volunteer Login</span>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="navLink navLast">
                    <a href="{{ route('admin-login') }}">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                        <span class="navText">Admin Login</span>
                    </a>
                </li>
        </ul>
    </div>
</nav>

@yield('content')


<!-- Putting our footer in there to have some copyright info and my name :) 
<footer class="footer">
    <span id="footerText">
        Rochester Museum and Science Center &copy; 2016 - Made by 
        Mark Armstrong
    </span>
</footer>

-->

</body>
</html>