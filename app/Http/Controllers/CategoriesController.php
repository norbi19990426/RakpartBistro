<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function create(){

        return view('categories.create');
    }
    public function store(){
        $data = request()->validate([
            'categoryName' => 'required',
        ]);

        Category::create($data);

        return redirect('/adminMenu');
    }
}
