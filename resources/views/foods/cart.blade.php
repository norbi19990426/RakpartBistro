@extends('layouts.app')
@section('content')
    <cart-component cart="{{json_encode(session()->get('cart'))}}" user-id="{{$id}}" user="{{ Auth::id() ? Auth::id() : 0 }}"></cart-component>
    <div class="container pt-2" style="border-top: 1px black solid">
        <a href="{{route('menu.index')}}">Vissza a menübe </a>
    </div>
@endsection
