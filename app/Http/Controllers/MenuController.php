<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Food;
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
        }
        else{
            $id = 0;
        }

        return view('more-page.menu', compact('categories', 'foods', 'id'));
    }
    public function indexAdmin()
    {
        $categories = Category::all();
        $foods = Food::all();

        return view('admin.menu', compact('categories', 'foods'));
    }
}
