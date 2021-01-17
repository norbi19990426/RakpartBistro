<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Food;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $foods = Food::all();

        return view('foods.menu', compact('categories', 'foods'));
    }
}
