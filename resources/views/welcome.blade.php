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
    <div class="container-fluid noPadding">
        <div class="row">
            <div class="col-12 welcomeCenter">
                <img class="welcome" src="/logo/Rakpart_KezdoBackground2.jpg">
            </div>
        </div>
        <div class="menuRecommenderContainer">
            <welcome-component
                foods="{{$foods}}">
            </welcome-component>
        </div>
    </div>
</body>
</html>
@endsection
