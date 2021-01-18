@extends('layouts.app')
@section('content')
<div class="row pb-2">
    <div class="col-2"></div>
    <div class="col-2">Étel</div>
    <div class="col-2">Étel ár</div>
    <div class="col-2 pl-5">Darab</div>
    <div class="col-2">Összérték</div>
    <div class="col-2"></div>
</div>
    @foreach (session()->get('cart') as $item)
    <cart-component cart="{{json_encode($item)}}"></cart-component>
    @endforeach
    <div class="container pt-2" style="border-top: 1px black solid">
        <a href="{{route('menu.index')}}">Vissza a menübe </a>
        <cart-item-component></cart-item-component>
    </div>
@endsection
