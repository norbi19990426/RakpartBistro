@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/cart.css') }}" rel="stylesheet">
</head>
<body class="allCart">
        <cart-component
            cart="{{$cart}}"
            payment-route="{{ route('paymentSuccess.index') }}"
            user-id="{{$id}}"
            ordered="{{$ordered}}"
            check="{{Auth::check()}}"
            profile="{{$profile}}"
            coupons="{{$coupons}}"
            used-coupons="{{$usedCoupons}}"
            coupon-used-once="{{$couponUsedOnce}}">
        </cart-component>
</body>
</html>
@endsection
