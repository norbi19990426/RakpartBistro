@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
</head>
<body >
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 welcomeHeader">
                <img class="welcome" src="/logo/Rakpart_KezdoBackground2.jpg">
            </div>
        </div>
        <div class="menuRecommenderContainer">
            <div class="menuRecommenderBorder">
                <welcome-component
                foods="{{$foods}}"
                user-id="{{$id}}">
                </welcome-component>
            </div>
        </div>
        <div class="row" style="height: 500px">

        </div>
    </div>
</body>
</html>
@endsection
