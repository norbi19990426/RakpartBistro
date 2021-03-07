<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function create(){
        $categories =  Category::all();

        return view('admin.categories.create', compact('categories'));
    }
    public function store(){
        $data = request()->validate([
            'categoryName' => 'required|max: 14',
        ]);

        Category::create($data);

        return redirect('/menu');
    }
    public function categoryEdit($categoryId){
        $data = request()->validate([
            'categoryName' => 'required|max: 14',
        ]);
        $category = Category::find($categoryId);
        $category->categoryName = $data['categoryName'];
        $category->save();
        return response($data);
    }
    public function categoryDelete($categoryId){
        $data[] = DB::table('foods')
        ->select('id')
        ->whereIn('category_id', [$categoryId])->get();
        if(empty($data[0])){
            DB::table('categories')
            ->whereIn('id', [$categoryId])->delete();
        }
        else{
            DB::table('categories')
            ->whereIn('id', [$categoryId])->delete();
            return response($data);
        }
    }
}
