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

        $categories = DB::table('categories')->get();


        return view('admin.foods.create', compact('categories'));
    }

    public function store(){
        $data = request()->validate([
            'foodName' => 'required|max:35',
            'description' => 'required|max:160',
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
    }
    public function foodEdit($foodId){
        $data = request()->validate([
            'foodName' => 'required|max:35',
            'description' => 'required|max:160',
            'price' => 'required',
            'image' => ''
        ]);
        if(request()->hasFile('image')){
            $imagePath = request('image')->store('uploads', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(150, 150);
            $image->save();
        }
        else{
            $imagePath = $data['image'];
        }

        $food = Food::find($foodId);
        $food->foodName = $data['foodName'];
        $food->price = $data['price'];
        $food->description = $data['description'];
        $food->image = $imagePath;
        $food->save();
        return response([
            'foodName' => $data['foodName'],
            'price' => $data['price'],
            'description'=> $data['description'],
            'image' => $imagePath
            ]);
    }
    public function deleteFood($foodId){
        DB::table('foods')
        ->whereIn('id', [$foodId])->delete();
        DB::table('ratings')
        ->whereIn('food_id', [$foodId])->delete();
    }
}

