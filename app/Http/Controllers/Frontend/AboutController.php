<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        return view('frontend.pages.about', [
            'page' => ['title' => 'About Better Nexus'],
            'latestArticles' => Blog::publicInsights()->latest('published_at')->orderByDesc('id')->limit(3)->get(),
        ]);
    }
}
