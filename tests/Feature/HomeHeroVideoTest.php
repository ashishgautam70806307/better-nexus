<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\HomeHero;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomeHeroVideoTest extends TestCase
{
    use RefreshDatabase;

    private function exampleUpload(): UploadedFile
    {
        return new UploadedFile(
            public_path('better-nexus/approved/team-desktop.mp4'),
            'hero.mp4',
            'video/mp4',
            null,
            true,
        );
    }

    public function test_each_slot_is_uploaded_as_draft_and_only_explicitly_published_content_is_public(): void
    {
        $this->withoutVite();
        Storage::fake('local');
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $this->put(route('admin.hero-video.update'), [
            'device' => 'desktop', 'video' => $this->exampleUpload(),
        ])->assertRedirect()->assertSessionHasNoErrors();

        $hero = HomeHero::findOrFail(1);
        $desktop = $hero->desktop_video_path;
        $this->assertTrue(HomeHero::isVideoUploadPath($desktop));
        $this->assertFalse((bool) $hero->desktop_video_published);
        Storage::disk('local')->assertExists($desktop);
        $this->get(route('admin.hero-video.preview', ['device'=>'desktop']))->assertOk();
        $this->get(route('home.hero-video', ['device'=>'desktop']))->assertNotFound();

        $this->put(route('admin.hero-video.publish'), [
            'is_active'=>'1', 'desktop_video_published'=>'1',
        ])->assertRedirect()->assertSessionHasNoErrors();
        $this->get(route('home.hero-video', ['device'=>'desktop']))->assertOk()
            ->assertHeader('Content-Type', 'video/mp4');
        $this->get(route('home.hero-video', ['device'=>'mobile']))->assertNotFound();

        $this->put(route('admin.hero-video.update'), [
            'device' => 'mobile', 'video' => $this->exampleUpload(),
        ])->assertRedirect()->assertSessionHasNoErrors();
        $hero->refresh();
        $this->assertFalse((bool) $hero->mobile_video_published);
        $this->assertTrue((bool) $hero->desktop_video_published);

        $this->put(route('admin.hero-video.publish'), [
            'is_active'=>'1', 'desktop_video_published'=>'1', 'mobile_video_published'=>'1',
        ])->assertRedirect()->assertSessionHasNoErrors();
        $this->get(route('home.hero-video', ['device'=>'mobile']))->assertOk();
        $this->get(route('home'))->assertOk()->assertSee('data-bn-clean-video');

        $this->delete(route('admin.hero-video.destroy'), ['device'=>'mobile'])->assertRedirect();
        $this->get(route('home.hero-video', ['device'=>'mobile']))->assertNotFound();
        $this->get(route('home.hero-video', ['device'=>'desktop']))->assertOk();
        $this->put(route('admin.hero-video.publish'), [
            'is_active'=>'1',
        ])->assertRedirect();
        $this->get(route('home.hero-video', ['device'=>'desktop']))->assertNotFound();
    }

    public function test_invalid_device_and_nonvideo_upload_are_rejected(): void
    {
        Storage::fake('local');
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $this->putJson(route('admin.hero-video.update'), [
            'device' => 'tablet',
            'video' => $this->exampleUpload(),
        ])->assertUnprocessable()->assertJsonValidationErrors('device');
        $this->putJson(route('admin.hero-video.update'), [
            'device' => 'desktop',
            'video' => UploadedFile::fake()->createWithContent('malware.mp4', '<?php echo 1;'),
        ])->assertUnprocessable()->assertJsonValidationErrors('video');
        $this->assertSame([], Storage::disk('local')->allFiles('home-hero-videos'));
    }

    public function test_non_admin_cannot_manage_hero_videos(): void
    {
        $this->putJson(route('admin.hero-video.update'), [
            'device'=>'desktop',
        ])->assertUnauthorized();
        $this->actingAs(User::factory()->create(['is_admin' => false]));
        $this->putJson(route('admin.hero-video.publish'), [
            'is_active'=>'1',
        ])->assertForbidden();
    }

    public function test_engineering_service_is_not_public(): void
    {
        $this->withoutVite();
        Blog::create([
            'title' => 'Archived engineering article',
            'slug' => 'archived-engineering',
            'category' => 'Engineering Services',
            'content' => 'Archived copy.',
            'is_published' => true,
            'published_at' => now()->subDay(),
        ]);
        $this->get('/blogs/archived-engineering')->assertNotFound();
        $this->get('/blogs')->assertOk()->assertDontSee('Archived engineering article');
        $this->get('/services/engineering-services')->assertNotFound();
        $this->get('/services')->assertOk()->assertDontSee('engineering-services');
    }
}
