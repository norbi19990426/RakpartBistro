@extends('layouts.app')
@section('content')
    <!DOCTYPE html>
    <html>
    <head>
        <link href="{{ asset('css/menu.css') }}" rel="stylesheet">
    </head>
    <body class="menu">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
            @foreach ($categories as $category)
                <a href="#" class="menuLink"> {{ $category->categoryName }}</a>
            @endforeach
            </div>
            <menu-component
                users ="{{json_encode($users)}}"
                categories="{{json_encode($categories)}}"
                foods="{{json_encode($foods)}}"
                user-id="{{$id}}"
                rate="{{$rate}}">
            </menu-component>
        </div>
    </body>
    </html>
@endsection
