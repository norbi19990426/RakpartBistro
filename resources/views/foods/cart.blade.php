@extends('layouts.app')
@section('content')
<cart-component cart="{{json_encode(session()->get('cart'))}}"></cart-component>
<div class="container">
    <a href="{{route('menu.index')}}">Vissza a menübe </a>
</div>
@endsection
