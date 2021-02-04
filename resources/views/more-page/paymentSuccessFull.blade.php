<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        html, body, #fullheight {
            background-image: url("/logo/Rakpart_KezdoBackground.jpg");
            min-height: 100% !important;
            height: 100%;
        }
        #fullheight {
            max-height: 100%;
        }

    </style>
</head>
<body>
    <div class="container" id="fullheight" style="background: #F8FAFC;">
        <div class="row justify-content-center">
            <img src="/logo/rakpartSzinesLogo.png" style="height: 150px;">
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
              <ul class="navbar-nav" style="font-size: 17px;">
                <li class="nav-item active">
                  <a class="nav-link" href="{{ url('/') }}">FŐOLDAL<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('menu.index')}}">MENÜ<span class="sr-only">(current)</span></a>
                </li>
              </ul>
            </div>
        </nav>
        <hr>
        <div class="row justify-content-center mt-5">
            <img src="/logo/correct.png" style="height: 100px;">
        </div>
        <div class="row justify-content-center">
            <h1>Köszönjük a rendelését</h1>
        </div>
        <div class="row justify-content-center">
            <h3>Várható kiszállítási idő</h3>
        </div>
        <div class="row justify-content-center" >
            @php
                $time = session()->get('time');
            @endphp
            <h5>{{$time}}</h5>
        </div>

    </div>
</body>
</html>
