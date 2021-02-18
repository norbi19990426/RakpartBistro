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
                    <div class="list-group p-2">
                        <a href="#" class="list-group-item list-group-item-action "> {{ $category->categoryName }}</a>
                    </div>
            @endforeach
            </div>
            <menu-component
                categories="{{json_encode($categories)}}"
                foods="{{json_encode($foods)}}"
                user-id="{{$id}}"
                rate="{{$rate}}">
            </menu-component>
        </div>
    </body>
    </html>
@endsection
