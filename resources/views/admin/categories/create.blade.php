@extends('layouts.app')

@section('content')

        <category-component
        categories="{{json_encode($categories)}}">
        </category-component>
@endsection
