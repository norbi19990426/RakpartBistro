@extends('layouts.app')
@section('content')
        <order-management-component order-management="{{json_encode($orders)}}" order-items="{{json_encode($orderItems)}}" food="{{json_encode($food)}}">

        </order-management-component>
@endsection
