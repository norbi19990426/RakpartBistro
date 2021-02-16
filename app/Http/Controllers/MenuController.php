<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Food;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $foods = Food::all();
        if(Auth::check()){
            $id = Auth::id();
            $rate = Rating::all();
        }
        else{
            $id = 0;
            $rate = 0;
        }

        return view('more-page.menu', compact('categories', 'foods', 'id', 'rate'));
    }
    public function setRating($foodId, $rate){
        Rating::create([
            'food_id' => $foodId,
            'user_id' => Auth::id(),
            'rating' => $rate,
        ]);
    }
    public function putRating($rateId, $rate){
        DB::table('ratings')
        ->whereIn('id', [$rateId])
        ->update(['rating' => $rate]);
    }
}
