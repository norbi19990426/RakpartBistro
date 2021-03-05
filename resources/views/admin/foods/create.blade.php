@extends('layouts.app')

@section('content')
    <food-create-component
    categories="{{json_encode($categories)}}">
    </food-create-component>
@endsection
