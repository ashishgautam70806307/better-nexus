<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\HomeHero;
// use App\Models\HomeHeroImage; // Archived image gallery.
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
    /* Archived image validation and cleanup.
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
    */
    public function edit()
    {
        return view("admin.hero.edit", [
            "hero" => $this->hero(),
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

            /* Archived image upload rules.
            "images" => "nullable|array|max:8",
            "images.*" => $this->imageRules(),
            */
        ]);
        /* Archived multiple image upload and append flow.
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
        */
        $v["is_active"] = $request->boolean("is_active");
        $this->hero()->update($v);
        return redirect()
            ->route("admin.hero-banners.index")
            ->with("success", "Homepage hero updated successfully.");
    }
    /* Archived image editor and removal actions.
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
    */
    public function updateVideo(Request $request)
    {
        $validated = $request->validate([
            'device' => ['required','in:desktop,mobile'],
            'video' => ['bail','required','file','mimetypes:video/mp4,video/webm','extensions:mp4,webm','min:1','max:102400'],
            'publication' => ['required', 'in:publish,draft'],
        ]);
        $device = $validated['device'];
        $publishNow = $validated['publication'] === 'publish';
        $file = $request->file('video');
        $type = (new \finfo(FILEINFO_MIME_TYPE))->file($file->getPathname());
        $extension = ['video/mp4'=>'mp4','video/webm'=>'webm'][$type] ?? null;
        if (!$extension || strtolower($file->getClientOriginalExtension()) !== $extension) {
            throw ValidationException::withMessages(['video'=>'Video extension and actual format must match.']);
        }
        $path = $file->storeAs('home-hero-videos', bin2hex(random_bytes(16)).'.'.$extension, 'local');
        if (!$path) throw ValidationException::withMessages(['video'=>'Upload failed. Try again.']);
        try {
            $old = DB::transaction(function () use ($device, $path, $publishNow) {
                $hero = HomeHero::whereKey(1)->lockForUpdate()->firstOrFail();
                $field = $device.'_video_path';
                $previous = $hero->{$field};
                // Publish immediately only when the administrator selects Upload & Publish.
                // The other device slot is never modified.
                $fields = [$field=>$path, $device.'_video_published'=>$publishNow];
                if ($publishNow) $fields['is_active'] = true;
                $hero->update($fields);
                return $previous;
            });
        } catch (\Throwable $e) {
            $this->removeVideoUpload($path);
            throw $e;
        }
        $this->removeVideoUpload($old);
        return back()->with('success', ucfirst($device).($publishNow ? ' video uploaded and published. Refresh the homepage to view it.' : ' video uploaded as draft. Preview, then publish.'));
    }

    public function publishVideos(Request $request)
    {
        $v = $request->validate([
            'desktop_video_published'=>['nullable','boolean'],
            'mobile_video_published'=>['nullable','boolean'],
            'is_active'=>['nullable','boolean'],
        ]);
        DB::transaction(function () use ($request) {
            $hero = HomeHero::whereKey(1)->lockForUpdate()->firstOrFail();
            foreach (['desktop','mobile'] as $device) {
                $path = $hero->{$device.'_video_path'};
                $publish = $request->boolean($device.'_video_published');
                if ($publish && (!HomeHero::isVideoUploadPath($path) || !Storage::disk('local')->exists($path))) {
                    throw ValidationException::withMessages([$device.'_video_published'=>'Upload a valid '.$device.' video before publishing.']);
                }
            }
            $hero->update([
                'desktop_video_published'=>$request->boolean('desktop_video_published'),
                'mobile_video_published'=>$request->boolean('mobile_video_published'),
                'is_active'=>$request->boolean('is_active'),
                // Stop legacy upload accidentally taking priority over explicit publication.
                'show_video'=>false,
            ]);
        });
        return back()->with('success', 'Hero publication settings saved.');
    }

    public function previewVideo(string $device)
    {
        abort_unless(in_array($device, ['desktop','mobile'], true), 404);
        $path = HomeHero::whereKey(1)->value($device.'_video_path');
        abort_unless(HomeHero::isVideoUploadPath($path) && Storage::disk('local')->exists($path),404);
        return response()->file(Storage::disk('local')->path($path), [
            'Content-Type'=>str_ends_with($path,'.mp4') ? 'video/mp4' : 'video/webm',
            'Cache-Control'=>'private, no-store, max-age=0',
            'X-Content-Type-Options'=>'nosniff',
        ])->setPrivate()->setContentDisposition('inline','preview-'.$device.'.'.pathinfo($path,PATHINFO_EXTENSION));
    }

    public function destroyVideo(Request $request)
    {
        $v = $request->validate(['device'=>['required','in:desktop,mobile']]);
        $device = $v['device'];
        $old = DB::transaction(function () use ($device) {
            $hero = HomeHero::whereKey(1)->lockForUpdate()->firstOrFail();
            $field = $device.'_video_path';
            $old = $hero->{$field};
            $hero->update([$field=>null, $device.'_video_published'=>false]);
            return $old;
        });
        $this->removeVideoUpload($old);
        return back()->with('success', ucfirst($device).' video removed.');
    }

    private function removeVideoUpload(?string $path): void
    {
        if (!HomeHero::isVideoUploadPath($path)) return;
        try {
            // Avoid deleting a file referenced in any slot (including legacy video_path).
            if (HomeHero::where('video_path',$path)->orWhere('desktop_video_path',$path)->orWhere('mobile_video_path',$path)->exists()) return;
            Storage::disk('local')->delete($path);
        } catch (\Throwable $error) { report($error); }
    }
}
