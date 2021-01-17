@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/f" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
            <div class="col-8 offset-2">
                <div class="row ">
                    <h1 class="col-md-6 text-md-right pb-3">Új étel </h1>
                </div>

                <div class="form-group row">
                    <label for="category_id" class="col-md-4 col-form-label text-md-right">Az étel kategóriája: </label>

                        <div class="col-md-6">
                            <select name="category_id" id="category_id" class="form-control input-lg dynamic" data-dependent="state">
                                @foreach ($categoryNames as $categorySec)
                                 <option value="{{ $categorySec->id}}">{{ $categorySec->categoryName }}</option>
                                 @endforeach
                            </select>
                        </div>
                    </form>
                </div>

                <div class="form-group row">
                    <label for="foodName" class="col-md-4 col-form-label text-md-right">Az étel neve: </label>

                    <div class="col-md-6">
                        <input id="foodName" type="text" class="form-control @error('name') is-invalid @enderror" name="foodName" value="{{ old('foodName') }}" required autocomplete="foodName" autofocus>

                        @error('foodName')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-right">Hozzávalók: </label>

                    <div class="col-md-6">
                        <input id="description"
                        type="text"
                        class="form-control
                        @error('description') is-invalid
                        @enderror"
                        name="description"
                        value="{{ old('description') }}"
                        required autocomplete="description" autofocus>

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="price" class="col-md-4 col-form-label text-md-right">Az étel ára: </label>

                    <div class="col-md-6">
                        <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" required autocomplete="price" autofocus>

                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="image" class="col-md-4 col-form-label text-md-right">Kép az ételről: </label>
                    <div class="col-md-6">

                        <input type="file" class="form-control-file" id="image" name="image">

                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <button class="btn btn-primary mt-4">Új étel hozzáadása</button>
                    </div>
                </div>


            </div>
        </div>
    </form>
</div>
@endsection
