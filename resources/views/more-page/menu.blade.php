@extends('layouts.app')
@section('content')
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
    </div>
@endsection
