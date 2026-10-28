<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
class BlogController extends Controller
{
    public function index(Request $r)
    {
        if ($r->ajax()) {
            return $this->tableData($r);
        }
        $categories = Blog::whereNotNull("category")
            ->where("category", "!=", "")
            ->distinct()
            ->orderBy("category")
            ->pluck("category");
        return view("admin.blogs.index", compact("categories"));
    }
    // Keeps the /blogs/data route from the manual tutorial compatible too.
    public function data(Request $r)
    {
        return $this->tableData($r);
    }

    private function tableData(Request $r)
    {
        $v = $r->validate([
            "status" => "nullable|in:draft,published,scheduled",
            "category" => "nullable|string|max:100",
            "length" => "sometimes|integer|in:10,25,50",
            "start" => "sometimes|integer|min:0",
            "search.value" => "nullable|string|max:100",
        ]);
        $q = Blog::query()->select([
            "id",
            "title",
            "category",
            "featured_image",
            "is_published",
            "published_at",
            "updated_at",
        ]);
        $status = $v["status"] ?? "";
        if ($status === "draft") {
            $q->where("is_published", false);
        }
        if ($status === "published") {
            $q->published();
        }
        if ($status === "scheduled") {
            $q->where("is_published", true)->where("published_at", ">", now());
        }
        if (!empty($v["category"])) {
            $q->where("category", $v["category"]);
        }
        return \Yajra\DataTables\Facades\DataTables::eloquent($q)
            ->addIndexColumn()
            ->addColumn(
                "thumbnail",
                fn(Blog $blog) => view(
                    "admin.blogs.partials.thumbnail",
                    compact("blog"),
                )->render(),
            )
            ->addColumn(
                "status_label",
                fn(Blog $blog) => !$blog->is_published
                    ? "Draft"
                    : (!$blog->published_at
                        ? "Unscheduled"
                        : ($blog->published_at->isFuture()
                            ? "Scheduled"
                            : "Published")),
            )
            ->editColumn(
                "updated_at",
                fn(Blog $blog) => $blog->updated_at?->format("d M Y") ?? "—",
            )
            ->addColumn(
                "actions",
                fn(Blog $blog) => view(
                    "admin.blogs.partials.actions",
                    compact("blog"),
                )->render(),
            )
            ->rawColumns(["thumbnail", "actions"])
            ->toJson();
    }
    public function create()
    {
        return view("admin.blogs.form", ["blog" => new Blog()]);
    }
    public function edit(Blog $blog)
    {
        return view("admin.blogs.form", compact("blog"));
    }
    private function validatedBlog(Request $r, ?Blog $blog = null): array
    {
        $d = $r->validate([
            "title" => "required|string|max:255",
            "category" => "nullable|string|max:100",
            "excerpt" => "nullable|string|max:20000",
            "content" => "required|string|max:200000",
            "author_name" => "nullable|string|max:150",
            "meta_title" => "nullable|string|max:255",
            "meta_description" => "nullable|string|max:300",
            "is_published" => "nullable|boolean",
            "published_at" => "nullable|date",
            "image" =>
                "nullable|image|mimes:jpg,jpeg,png,webp|max:4096|dimensions:max_width=6000,max_height=6000",
            "remove_image" => "nullable|boolean",
        ]);
        unset($d["image"], $d["remove_image"]);
        $d["content"] = \App\Support\BlogText::store($d["content"]);
        $d["excerpt"] = \App\Support\BlogText::store($d["excerpt"] ?? "");
        if (mb_strlen(\App\Support\BlogText::plain($d["excerpt"])) > 500) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                "excerpt" =>
                    "Short description must be 500 characters or fewer.",
            ]);
        }

        if (trim(\App\Support\BlogText::plain($d["content"])) === "") {
            throw \Illuminate\Validation\ValidationException::withMessages([
                "content" => "Please write the article content.",
            ]);
        }
        $d["title"] = trim($d["title"]);
        $d["author_name"] = trim($d["author_name"] ?? "") ?: "Better Nexus";
        $d["excerpt"] =
            \App\Support\BlogText::plain($d["excerpt"]) !== ""
                ? $d["excerpt"]
                : \App\Support\BlogText::store(
                    "<p>" .
                        e(
                            \Illuminate\Support\Str::limit(
                                \App\Support\BlogText::plain($d["content"]),
                                240,
                            ),
                        ) .
                        "</p>",
                );
        $d["is_published"] = $r->boolean("is_published");
        $d["published_at"] = $d["published_at"] ?? null;
        if ($d["is_published"] && !$d["published_at"]) {
            $d["published_at"] = now();
        }
        // Preserve the URL on edit; never trust a posted hidden slug.
        if (!$blog) {
            $d["slug"] = $this->uniqueSlug($d["title"]);
        }
        return $d;
    }
    private function uniqueSlug(string $title): string
    {
        $base =
            substr(\Illuminate\Support\Str::slug($title), 0, 220) ?: "article";
        $slug = $base;
        $i = 2;
        while (Blog::where("slug", $slug)->exists()) {
            $slug = $base . "-" . $i++;
        }
        return $slug;
    }
    public function store(Request $r)
    {
        $d = $this->validatedBlog($r);
        $path = null;
        try {
            if ($r->hasFile("image")) {
                $path = $r->file("image")->store("blogs", "public");
                if (!$path) { throw new \RuntimeException("Unable to store blog image."); }
                $d["featured_image"] = "storage/" . $path;
            }
            for ($attempt = 0; ; $attempt++) {
                try {
                    Blog::create($d);
                    break;
                } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
                    if ($attempt >= 4) {
                        throw $e;
                    }
                    $d["slug"] = $this->uniqueSlug($d["title"]);
                }
            }
        } catch (\Throwable $e) {
            if ($path) {
                Storage::disk("public")->delete($path);
            }
            throw $e;
        }
        return redirect()
            ->route("admin.blogs.index")
            ->with("success", "Article created.");
    }
    public function update(Request $r, Blog $blog)
    {
        $d = $this->validatedBlog($r, $blog);
        $old = $blog->featured_image;
        $path = null;
        if ($r->boolean("remove_image")) {
            $d["featured_image"] = null;
        }
        try {
            if ($r->hasFile("image")) {
                $path = $r->file("image")->store("blogs", "public");
                if (!$path) { throw new \RuntimeException("Unable to store blog image."); }
                $d["featured_image"] = "storage/" . $path;
            }
            $blog->update($d);
        } catch (\Throwable $e) {
            if ($path) {
                Storage::disk("public")->delete($path);
            }
            throw $e;
        }
        if ($old !== $blog->featured_image) {
            $this->removeUpload($old);
        }
        return redirect()
            ->route("admin.blogs.index")
            ->with("success", "Article updated.");
    }
    private function removeUpload(?string $path): void
    {
        if (
            $path &&
            preg_match(
                '~^storage/blogs/[A-Za-z0-9_-]+\.(?:jpg|jpeg|png|webp)$~i',
                $path,
            ) &&
            !Blog::where("featured_image", $path)->exists()
        ) {
            Storage::disk("public")->delete(substr($path, 8));
        }
    }
    public function destroy(Blog $blog)
    {
        $image = $blog->featured_image;
        $blog->delete();
        $this->removeUpload($image);
        return redirect()
            ->route("admin.blogs.index")
            ->with("success", "Article deleted.");
    }
}
