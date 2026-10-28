<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\HomeHero;
use App\Models\HomeHeroImage;
use App\Rules\SafeWebsiteLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
class HomeHeroController extends Controller
{
    private function hero(): HomeHero
    {
        return HomeHero::findOrFail(1);
    }
    private function imageRules(): array
    {
        return [
            "image",
            "mimes:jpg,jpeg,png,webp",
            "max:4096",
            "dimensions:min_width=100,min_height=100,max_width=6000,max_height=6000",
        ];
    }
    private function removeUpload(?string $path): void
    {
        // Never unlink a bundled asset or a path supplied by the browser.
        if (
            $path &&
            preg_match(
                '~^storage/home-hero/[A-Za-z0-9_-]+\.(jpe?g|png|webp)$~i',
                $path,
            ) &&
            !HomeHeroImage::where("path", $path)->exists()
        ) {
            Storage::disk("public")->delete(substr($path, 8));
        }
    }
    public function edit()
    {
        return view("admin.hero.edit", [
            "hero" => $this->hero()->load("images"),
        ]);
    }
    public function update(Request $request)
    {
        $v = $request->validate([
            "eyebrow" => "nullable|string|max:150",
            "title" => "required|string|max:180",
            "highlight" => "nullable|string|max:180",
            "description" => "nullable|string|max:1500",
            "primary_label" =>
                "nullable|required_with:primary_url|string|max:70",
            "primary_url" => [
                "nullable",
                "required_with:primary_label",
                "string",
                "max:1000",
                new SafeWebsiteLink(),
            ],
            "secondary_label" =>
                "nullable|required_with:secondary_url|string|max:70",
            "secondary_url" => [
                "nullable",
                "required_with:secondary_label",
                "string",
                "max:1000",
                new SafeWebsiteLink(),
            ],
            "is_active" => "nullable|boolean",
            "show_video" => "nullable|boolean",
            "images" => "nullable|array|max:8",
            "images.*" => $this->imageRules(),
        ]);
        $new = [];
        try {
            foreach ($request->file("images", []) as $file) {
                $path = $file->store("home-hero", "public");
                if (!$path) {
                    throw new \RuntimeException("Unable to store hero image.");
                }
                $new[] = $path;
            }
            DB::transaction(function () use ($request, $v, $new) {
                // All hero mutations lock this singleton, including image deletes and edits.
                $hero = HomeHero::whereKey(1)->lockForUpdate()->firstOrFail();
                if ($hero->images()->count() + count($new) > 16) {
                    throw ValidationException::withMessages([
                        "images" =>
                            "Keep up to 16 images total. Remove an old image before adding more.",
                    ]);
                }
                unset($v["images"]);
                $v["is_active"] = $request->boolean("is_active");
                $v["show_video"] = $request->boolean("show_video");
                $hero->update($v);
                $rank = (int) $hero->images()->max("sort_order");
                foreach ($new as $path) {
                    $hero
                        ->images()
                        ->create([
                            "path" => "storage/" . $path,
                            "alt" => "",
                            "sort_order" => ++$rank,
                            "is_active" => true,
                        ]);
                }
            });
        } catch (\Throwable $e) {
            foreach ($new as $path) {
                Storage::disk("public")->delete($path);
            }
            throw $e;
        }
        return redirect()
            ->route("admin.hero-banners.index")
            ->with("success", "Homepage hero updated successfully.");
    }
    public function updateImage(Request $request, HomeHeroImage $image)
    {
        abort_unless((int) $image->home_hero_id === 1, 404);
        $v = $request->validate([
            "alt" => "nullable|string|max:180",
            "sort_order" => "required|integer|min:0|max:9999",
            "is_active" => "nullable|boolean",
            "image" => array_merge(["nullable"], $this->imageRules()),
        ]);
        $new = null;
        $old = null;
        try {
            if ($request->hasFile("image")) {
                $new = $request->file("image")->store("home-hero", "public");
                if (!$new) {
                    throw new \RuntimeException("Unable to store image.");
                }
            }
            DB::transaction(function () use (
                $request,
                $image,
                $v,
                $new,
                &$old,
            ) {
                HomeHero::whereKey(1)->lockForUpdate()->firstOrFail();
                $row = HomeHeroImage::whereKey($image->id)
                    ->lockForUpdate()
                    ->firstOrFail();
                $old = $row->path;
                unset($v["image"]);
                $v["is_active"] = $request->boolean("is_active");
                if ($new) {
                    $v["path"] = "storage/" . $new;
                }
                $row->update($v);
            });
        } catch (\Throwable $e) {
            if ($new) {
                Storage::disk("public")->delete($new);
            }
            throw $e;
        }
        if ($new) {
            $this->removeUpload($old);
        }
        return back()->with("success", "Hero image updated successfully.");
    }
    public function destroyImage(HomeHeroImage $image)
    {
        abort_unless((int) $image->home_hero_id === 1, 404);
        $old = DB::transaction(function () use ($image) {
            HomeHero::whereKey(1)->lockForUpdate()->firstOrFail();
            $row = HomeHeroImage::whereKey($image->id)
                ->lockForUpdate()
                ->firstOrFail();
            $path = $row->path;
            $row->delete();
            return $path;
        });
        $this->removeUpload($old);
        return back()->with("success", "Hero image removed successfully.");
    }
}
