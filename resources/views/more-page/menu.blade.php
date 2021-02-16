@extends('layouts.app')
@section('content')
   <!-- <div class="container-fluid">
        <div class="row d-flex justify-content-center">
        @foreach ($categories as $category)
                <div class="list-group p-2">
                    <a href="#" class="list-group-item list-group-item-action"> {{ $category->categoryName }}</a>
                </div>
        @endforeach
        </div>
    </div>
        @foreach ($categories as $category)
            <h2 class="pt-5">{{$category->categoryName}}</h2>
                <div class="row">
                    @foreach ($foods as $food)
                        @if ($category->id == $food->category_id )
                            <menu-component
                                foods="{{json_encode($food)}}"
                                user-id="{{$id}}"
                                rate="{{$rate}}">
                            </menu-component>
                        @endif
                    @endforeach
                <br>
            </div>
        @endforeach
    </div>-->
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
        @foreach ($categories as $category)
                <div class="list-group p-2">
                    <a href="#" class="list-group-item list-group-item-action"> {{ $category->categoryName }}</a>
                </div>
        @endforeach
        </div>
    </div>
        @foreach ($categories as $category)
            <h2 class="pt-5">{{$category->categoryName}}</h2>
                <div class="row">
                    @foreach ($foods as $food)
                        @if ($category->id == $food->category_id )
                            <div class="col-sm-4 pt-4">
                                <div class="card">
                                    <div class="d-flex justify-content-between">
                                    <img src="/storage/{{$food->image}}" class="float-left pr-3" >
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h4 class="card-title">{{$food->foodName }}</h4>
                                            <p class="text-md-right">{{$food->price}} HUF</p>
                                        </div>
                                        <p class="card-text">{{$food->description}}</p>
                                        <div class="d-flex justify-content-end">
                                            <addtocart-component food-id="{{$food->id}}" user-id="{{$id}}"></addtocart-component>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                <br>
            </div>
        @endforeach
    </div>
@endsection
