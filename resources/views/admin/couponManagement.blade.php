@extends('layouts.app')
@section('content')
   <!DOCTYPE html>
   <html lang="hu">
   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link href="{{ asset('css/coupon.css') }}" rel="stylesheet">
   </head>
   <body>
        <coupon-management-component
        coupons="{{json_encode($coupons)}}"
        usage="{{json_encode($usage)}}"
        create-coupon="{{route('admin.createCoupon.create')}}">
        </coupon-management-component>
   </body>
   </html>
@endsection
