@extends('layouts.app')
@section('content')
    <cart-component cart="{{json_encode(session()->get('cart'))}}"></cart-component>
    <div class="container pt-2" style="border-top: 1px black solid">
        <a href="{{route('menu.index')}}">Vissza a menübe </a>
    </div>
@endsection
