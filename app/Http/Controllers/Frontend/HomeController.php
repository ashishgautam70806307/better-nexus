<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\HomeHero;
use Illuminate\Support\Facades\Storage;
class HomeController extends Controller
{
    private function publishedHeroVideos(): array
    {
        $hero = HomeHero::find(1);
        $result = ['desktop' => null, 'mobile' => null];
        if (!$hero || !$hero->is_active) return $result;
        foreach (['desktop', 'mobile'] as $device) {
            // Legacy single-video deployments continue to work until the new migration is run.
            $path = $device === 'desktop' ? $hero->desktop_video_path : $hero->mobile_video_path;
            $published = (bool) $hero->{$device.'_video_published'};
            if ($device === 'desktop' && !$path && $hero->show_video) {
                $path = $hero->video_path;
                $published = true;
            }
            if ($published && HomeHero::isVideoUploadPath($path) && Storage::disk('local')->exists($path)) {
                $result[$device] = $path;
            }
        }
        return $result;
    }
    public function index()
    {
        $videos = $this->publishedHeroVideos();
        // Unique filename changes on every upload: version the URLs so the browser
        // cannot reuse a previously cached desktop/mobile response.
        $desktopUrl = $videos['desktop'] ? route('home.hero-video', ['device'=>'desktop', 'v'=>pathinfo($videos['desktop'], PATHINFO_FILENAME)]) : null;
        $mobileUrl = $videos['mobile'] ? route('home.hero-video', ['device'=>'mobile', 'v'=>pathinfo($videos['mobile'], PATHINFO_FILENAME)]) : null;
        return view('frontend.home', [
            'heroDesktopVideo' => $desktopUrl,
            'heroMobileVideo' => $mobileUrl,
            'latestBlogs' => Blog::publicInsights()->latest('published_at')->orderByDesc('id')->limit(3)->get(),
            'services' => config('virtual-assistant', []),
        ]);
    }
    public function video(string $device = 'desktop')
    {
        abort_unless(in_array($device, ['desktop','mobile'], true), 404);
        $path = $this->publishedHeroVideos()[$device];
        abort_unless($path, 404);
        $file = Storage::disk('local')->path($path);
        abort_unless(is_file($file) && is_readable($file), 404);
        return response()->file($file, [
            'Content-Type' => str_ends_with($path, '.mp4') ? 'video/mp4' : 'video/webm',
            'Cache-Control' => 'private, no-store, max-age=0',
            'Pragma' => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ])->setContentDisposition('inline', 'hero-'.$device.'.'.pathinfo($path, PATHINFO_EXTENSION));
    }
}
