<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\ContactEnquiry;
class DashboardController extends Controller
{
    public function index()
    {
        $totalBlogs = Blog::count();
        $published = Blog::published()->count();
        $drafts = Blog::where('is_published', false)->count();
        $scheduled = Blog::where('is_published', true)->where('published_at', '>', now())->count();
        $totalHeroImages = \App\Models\HomeHeroImage::count();
        $activeHeroImages = \App\Models\HomeHeroImage::where('is_active', true)->count();
        $percent = fn (int $count, int $total): int => $total ? min(100, (int) round($count / $total * 100)) : 0;
        return view("admin.dashboard", [
            'overview' => [
                ['Published blogs', $published, 'article', $percent($published, $totalBlogs)],
                ['Draft blogs', $drafts, 'article', $percent($drafts, $totalBlogs)],
                ['Scheduled blogs', $scheduled, 'article', $percent($scheduled, $totalBlogs)],
                ['Hero images', $activeHeroImages, 'layers', $percent($activeHeroImages, $totalHeroImages)],
            ],
            "published" => $published,
            "drafts" => $drafts,
            "recent" => Blog::latest("updated_at")->limit(4)->get(),
            "totalEnquiries" => ContactEnquiry::count(),
            "newEnquiries" => ContactEnquiry::where("status", "new")->count(),
            "activeHeroImages" => $activeHeroImages,
            "recentEnquiries" => ContactEnquiry::latest("id")->limit(5)->get(),
        ]);
    }
}
