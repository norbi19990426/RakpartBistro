<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\Food;
use Intervention\Image\Facades\Image;


class FoodsController extends Controller
{
    public function create(){

        $categoryNames = DB::table('categories')->groupBy('categoryName')->get();


        return view('foods.create', compact('categoryNames'));
    }

    public function store(){


        $data = request()->validate([
            'foodName' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => ['required', 'image'],
            'category_id' => 'required',
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(150, 150);
        $image->save();

        Food::create([
            'foodName' => $data['foodName'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $imagePath,
            'category_id' => $data['category_id'],
        ]);

            return redirect('/adminMenu');

    }
}

