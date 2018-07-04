<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\{Article, Website, Category};

class DashboardAdminController extends Controller
{
    public function index()
    {
        $website_non_private_count = Website::where('private', Website::WEBSITE_NON_PRIVATE)->count();
        $website_private_count = Website::where('private', Website::WEBSITE_PRIVATE)->count();
        $articles_count = Article::count();
        $categories_count = Category::count();

        return view('admin.dashboard', compact(
            'website_non_private_count',
            'website_private_count',
            'articles_count',
            'categories_count'
        ));
    }
}
