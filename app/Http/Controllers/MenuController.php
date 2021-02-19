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
        $users = User::all();
        $rate = json_encode(Rating::all());
        if(Auth::check()){
            $id = Auth::id();
        }
        else{
            $id = 0;
        }

        return view('more-page.menu', compact('categories', 'foods', 'id', 'rate','users'));
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
    public function getRating($foodId, $userId){
        $foodRate = DB::table('ratings')
            ->select('rating')
            ->whereIn('food_id', [$foodId])
            ->whereIn('user_id', [$userId])
            ->get();
        return response($foodRate);
    }
    public function avgRating($foodId){
        $foodRate = DB::table('ratings')
            ->whereIn('food_id', [$foodId])
            ->groupBy('food_id')
            ->avg('rating');
        return response($foodRate);
    }
}
