<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TECHNO PHARMACY </title>
        <link rel="shortcut icon" type="image/x-icon" href="img/fav-icon.png">


        <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 74px;
                color: #fff;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        <style>
body {
  background-image: url("img/bg.jpg"); /* The image used */
  background-repeat: no-repeat; /* Do not repeat the image */
  background-size: cover; /* Resize the background image to cover the entire container */
overflow-y: hidden;
}

.hero{
    background-color:#a52a2ad9;
    width:100%;
    height:100%;
}
</style>
    </head>
    <body>
         <div class="hero">
   <div class="panel panel-default">
    <div class="panel-body">
        <img src="img/Logo.png" width="200px">  

 @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                          <!--  <a href="{{ route('register') }}">Register</a>-->
                        @endif
                    @endauth
                </div>
            @endif
    </div>
</div>

        <div class="flex-center position-ref full-height">
           

            <div class="content">
                <a href="{{ route('login') }}" class="btn btn-danger">Login to System</a>
                <div class="title m-b-md">
                    Welcome to techno pharmacy
                </div>
                 


            </div>
        </div>
        </div>
    </body>
</html>
