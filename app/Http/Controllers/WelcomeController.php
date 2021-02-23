<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index(){

        $foods = Food::all();

        return view('welcome', compact('foods'));
    }
    public function getBestFood(){
        $foodRate = DB::table('ratings')
        ->select('food_id', DB::raw('SUM(rating) as bestRating'))
        ->groupBy('food_id')
        ->orderBy('bestRating', 'desc')
        ->limit(1)
        ->get();

        return response($foodRate);
    }
}
