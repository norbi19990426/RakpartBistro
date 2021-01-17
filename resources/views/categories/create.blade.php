@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/c" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="col align-self-center">
            <label for="categoryName" class="col-form-label text-md-center"><h1>Új kategória: </h1></label>

            <input id="categoryName" type="text" class="form-control @error('categoryName') is-invalid @enderror" name="categoryName" value="{{ old('categoryName') }}" required autocomplete="categoryName" autofocus>
                 @error('categoryName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            <button class="btn btn-primary mt-4">Új kategória hozzáadása</button>
        </div>
    </form>
</div>
@endsection
