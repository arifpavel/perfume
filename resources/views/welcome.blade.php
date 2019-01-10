<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <meta name="csrf-token" content="{{ csrf_token()}}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
                font-size: 84px;
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
            .search-box {
                position: relative;
                
            }
            .search-box input {
                text-color: #fa8c52;
                padding-left: 60px;
                /* background: #546e7a; */
                border: 2px #fa8c52 solid;
                outline: #666 !important;
                transition: all 0.2s linear;
            }
            .search-box input:focus {
                background: #fff !important;
                outline: 0;
                color: #333;
            }
            .search-box input:hover {
                background: #78909c;
            }
        </style>
</head>

<body>
    <div class="container" id="app">
        {{-- @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif --}}

        <div class="content">

            <div class="title m-b-md">
                <img src="{{asset('img/logo.png')}}" alt="logo" class="img-responsive" style="height:100px;width:100px;">
                Perfume <b>DB</b>
            </div>
            {{-- <div class="search-box">
                    <div class="input-group input-group-lg">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="inputGroup-sizing-lg"><i class="fa fa-search"></i></span>
                            </div>
                            <input @keyup="searchPerfume" v-model="perfumeKey" type="text" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm" 
                            placeholder="Search Your Favourite Perfume...">
                          </div>
            </div> --}}
            {{-- Including home vue component --}}
            <home-component></home-component>
            <div class="links mt-5">
                <p>Copyright &copy;2019 Made with <i class="fa fa-heart"></i> By <a href="http://skewsoft.com">Skew
                        Soft</a></p>
            </div>
        </div>
    </div>
    <!-- Main App -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
