<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
class BlogController extends Controller
{
    public function index(Request $request)
    {
        $v = $request->validate(["search" => "nullable|string|max:100"]);
        $search = trim($v["search"] ?? "");
        $blogs = Blog::published()
            ->when(
                $search,
                fn($q) => $q->where(
                    fn($q) => $q
                        ->where("title", "like", "%{$search}%")
                        ->orWhere("category", "like", "%{$search}%"),
                ),
            )
            ->latest("published_at")
            ->orderByDesc("id")
            ->paginate(9)
            ->withQueryString();
        return view("frontend.blogs.index", compact("blogs", "search"));
    }
    public function show(string $slug)
    {

        $blog = Blog::published()->where("slug", $slug)->firstOrFail();
        $related = Blog::published()
            ->whereKeyNot($blog->id)
            ->latest("published_at")
            ->limit(3)
            ->get();
        return view("frontend.blogs.show", compact("blog", "related"));
    }
    public function legacyIndex()
    {
        return redirect()->route("blogs.index", [], 301);
    }
    public function legacyShow(string $slug)
    {
        return redirect()->route("blogs.show", ["slug" => $slug], 301);
    }
}
