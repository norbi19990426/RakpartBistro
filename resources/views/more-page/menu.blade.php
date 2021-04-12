@extends('layouts.app')
@section('content')
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/menu.css') }}" rel="stylesheet">
    </head>
    <body class="menu">
        <menu-component
            users ="{{json_encode($users)}}"
            categories="{{json_encode($categories)}}"
            foods="{{json_encode($foods)}}"
            user-id="{{$id}}"
            rate="{{$rate}}"
            admin="{{$admin}}">
        </menu-component>
    </body>
    </html>
@endsection
