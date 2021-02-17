@extends('layouts.app')
@section('content')
    <div class="container-fluid">
            <cart-component
            cart="{{$cart}}"
            payment-route="{{ route('paymentSuccess.index') }}"
            user-id="{{$id}}"
            ordered="{{$ordered}}"
            check="{{Auth::check()}}"
            coupons="{{$coupons}}"
            used-coupons="{{$usedCoupons}}"
            coupon-used-once="{{$couponUsedOnce}}">
            </cart-component>
    </div>
@endsection
