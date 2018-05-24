<?php

namespace App\Http\Controllers;

use App\Category;

class ApiCategoryController extends Controller
{
    public function categories()
    {
        return $this->responseOne(Category::with('subCategory')->get());
    }
}
