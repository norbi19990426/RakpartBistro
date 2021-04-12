@extends('layouts.app')
@section('content')
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/create.css') }}" rel="stylesheet">
    </head>
    <body>
        <category-component
            categories="{{json_encode($categories)}}">
        </category-component>
    </body>
    </html>
@endsection
