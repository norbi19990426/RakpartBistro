<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function create(){

        return view('admin.categories.create');
    }
    public function store(){
        $data = request()->validate([
            'categoryName' => 'required|14',
        ]);

        Category::create($data);

        return redirect('/menu');
    }
}
