<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\{Article, User, Website, Category};

class DashboardAdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard')->with([
            'user_count' => User::count(),
            'website_count' => Website::count(),
            'articles_count' => Article::count(),
            'categories_count' => Category::count()
        ]);
    }
}
