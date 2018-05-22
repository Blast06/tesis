<?php

namespace App\Http\Controllers;

use App\Category;


class ApiCategoryController extends Controller
{
    public function categories()
    {
        $categories = Category::with('subCategory')->get();
        
        return response()->json(['data' => $categories], 200);
    }
}
