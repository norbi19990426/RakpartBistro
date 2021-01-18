@extends('layouts.app')

@section('content')
<div class="container-fluid">

        <a href="{{route('categories.create')}}">Új Kategória</a>
        <div class="row d-flex">
        @foreach ($categories as $category)
                <div class="list-group p-2">
                    <a href="#" class="list-group-item list-group-item-action"> {{ $category->categoryName }}</a>
                </div>
        @endforeach
        </div>
        <a href="{{route('foods.create')}}">Új Ételek</a>
        @foreach ($categories as $category)
            <h2 class="pt-5">{{$category->categoryName}}</h2>
                <div class="row">
                    @foreach ($foods as $food)
                        @if ($category->id == $food->category_id )
                            <div class="col-md-4 pt-4">
                                <img src="/storage/{{$food->image}}" class="float-left pr-3" >
                                <div class="d-flex justify-content-between">
                                    <h4>{{$food->foodName }}</h4>
                                    <p class="text-md-right">{{$food->price}} HUF</p>
                                </div>
                                <p>{{$food->description}}</p>
                                <addtocart-component food-id="{{$food->id}}"></addtocart-component>
                            </div>
                        @endif

                    @endforeach
                <br>
            </div>
        @endforeach
</div>
@endsection