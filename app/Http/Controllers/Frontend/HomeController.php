<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Blog;
// use App\Models\HomeHero; // Preserved: homepage now uses a local video.
class HomeController extends Controller
{
    public function index()
    {
        return view("frontend.home", [
            // Archived hero query: admin data and image files remain untouched.
            // "hero" => HomeHero::with([
            //     "images" => fn($q) => $q->where("is_active", true),
            // ])->find(1),
            "latestBlogs" => Blog::published()
                ->latest("published_at")
                ->orderByDesc("id")
                ->limit(3)
                ->get(),
            "services" => config("frontend.services", []),
        ]);
    }
}
