@extends('layouts.app')
@section('content')
    <div class="container-fluid">
            <cart-component cart="{{json_encode(session()->get('cart'))}}" user-id="{{$id}}" user="{{ Auth::id() ? Auth::id() : 0 }}">
            </cart-component>
    </div>
@endsection
