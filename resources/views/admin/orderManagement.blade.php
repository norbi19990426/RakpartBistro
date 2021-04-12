@extends('layouts.app')
@section('content')
    <!DOCTYPE html>
    <html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/order.css') }}" rel="stylesheet">
    </head>
    <body>
        <order-management-component
        order-management="{{json_encode($orders)}}"
        order-items="{{json_encode($orderItems)}}"
        food="{{json_encode($food)}}"
        order-statuses="{{json_encode($statuses)}}"
        coupons="{{json_encode($coupons)}}">
        </order-management-component>
    </body>
    </html>
@endsection
