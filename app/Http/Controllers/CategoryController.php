<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryController extends Controller
{
    public function categories()
    {
        return $this->showAll(Category::with('subCategory')->get());
    }
}
