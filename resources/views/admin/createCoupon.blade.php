@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <form action="/coupon" enctype="multipart/form-data" method="POST" >
            @csrf
            <div class="row ">
                <h1 class="text-md-right pb-3">Új Kupon</h1>
            </div>
            <div class="form-group row">
                <label for="couponName">Kupon elnezevezés:</label>
                <input type="text" class="form-control @error('couponName') is-invalid @enderror" id="couponName" name="couponName"  value="{{ old('couponName') }}" required autocomplete="couponName" autofocus>

                @error('couponName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group row">
                <label for="couponPercent">Százalék mennyisége:</label>
                <input type="number" class="form-control" id="couponPercent" name="couponPercent">
            </div>
            <div class="form-group row">
                <label for="usages_id">Egyszer vagy többször használatos kupon:</label>
                <select class="form-control" name="usages_id" id="usages_id">
                    <option value="1">Egyszer használatos</option>
                    <option value="2">Többször használatos</option>
                </select>

            <button class="btn btn-primary mt-3">Létrehozás</button>
            </div>
        </form>
    </div>
</div>
@endsection
