@extends('layouts.app')
@section('content')
    <coupon-management-component
    coupons="{{json_encode($coupons)}}"
    usage="{{json_encode($usage)}}">
    </coupon-management-component>
@endsection
