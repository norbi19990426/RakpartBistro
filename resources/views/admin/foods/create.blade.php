@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/food.css') }}" rel="stylesheet">
    </head>
    <body>
        <food-create-component
            categories="{{json_encode($categories)}}">
        </food-create-component>
    </body>
    </html>
@endsection
