<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index()
    {
        return $this->showAll(Category::with('subCategory')->get());
       
    }

    public function show($id)
    {
       
        $articles = Article::where('sub_category_id', $id)->get();

        return response()->json($articles);
    }

    
}
