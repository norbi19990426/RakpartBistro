@extends('layouts.app')
@section('content')
        <order-management-component order-management="{{json_encode($orders)}}"
        order-items="{{json_encode($orderItems)}}" food="{{json_encode($food)}}"
        order-statuses="{{json_encode($statuses)}}">

        </order-management-component>
@endsection