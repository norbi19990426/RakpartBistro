@extends('layouts.app')
@section('content')
    <!DOCTYPE html>
    <html>
    <head>
        <link href="{{ asset('css/menu.css') }}" rel="stylesheet">
    </head>
    <body class="menu">
        <div class="container">
            <menu-component
                users ="{{json_encode($users)}}"
                categories="{{json_encode($categories)}}"
                foods="{{json_encode($foods)}}"
                user-id="{{$id}}"
                rate="{{$rate}}"
                admin="{{$admin}}">
            </menu-component>
        </div>
    </body>
    </html>
@endsection
