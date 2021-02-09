@extends('layouts.app')
@section('content')
    <coupon-management-component coupons="{{json_encode($coupons)}}">

    </coupon-management-component>
@endsection
