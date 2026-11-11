<?php

namespace Tests\Feature;

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BetterNexusFrontendTest extends TestCase
{
    use RefreshDatabase;
    public function test_all_frontend_pages_render(): void
    {
        $this->withoutVite();
        foreach (['home', 'about', 'contact-us', 'services.index', 'blogs.index'] as $name) {
            $this->get(route($name))->assertOk()->assertSee('Better Nexus');
        }
        foreach (array_keys(config('virtual-assistant')) as $slug) {
            $this->get(route('services.show', ['slug' => $slug]))->assertOk()->assertSee('bn-experience-detail');
        }
        $article = Blog::create([
            'title' => 'A frontend test article',
            'slug' => 'a-frontend-test-article',
            'excerpt' => 'A short introduction.',
            'content' => '<p>Published content for the frontend check.</p>',
            'author_name' => 'Better Nexus',
            'is_published' => true,
            'published_at' => now()->subMinute(),
        ]);

        $this->get(route('blogs.show', ['slug' => $article->slug]))->assertOk()->assertSee($article->title);
    }

    public function test_previous_case_study_urls_redirect_to_matching_blogs(): void
    {
        $this->get('/case-studies')->assertStatus(301)->assertRedirect(route('blogs.index'));
        foreach (array_keys(config('frontend.blogs')) as $slug) {
            $this->get('/case-studies/'.$slug)->assertStatus(301)->assertRedirect(route('blogs.show', ['slug' => $slug]));
        }
    }

    public function test_unknown_slugs_return_404(): void
    {
        $this->withoutVite();
        $this->get('/services/not-a-service')->assertNotFound();
        $this->get('/blogs/not-an-article')->assertNotFound();
        $this->followingRedirects()->get('/case-studies/not-an-article')->assertNotFound();
    }

    public function test_navigation_has_one_blogs_link_and_no_case_studies_label(): void
    {
        $this->withoutVite();
        $response = $this->get(route('home'))->assertOk()->assertDontSee('Case Studies');
        $html = $response->getContent();
        preg_match('/<nav class="bn2-nav"[^>]*>(.*?)<\/nav>/s', $html, $matches);
        $this->assertSame(1, substr_count($matches[1] ?? '', route('blogs.index')));
    }

    public function test_navigation_and_contact_form_are_connected(): void
    {
        $this->withoutVite();
        $contact = route('contact-us').'#bn-contact-live';
        $home = $this->get(route('home'))->assertOk()->assertSee($contact, false);
        $home->assertSee('aria-controls="bn2-mobile-nav"', false);
        $home->assertSee('id="bn2-mobile-nav"', false);
        $home->assertSee('id="better-nexus-va-styles"', false);

        $this->get($contact)->assertOk()->assertSee('id="bn-contact-live"', false);

        $data = [
            'name' => 'Test Visitor',
            'email' => 'test@example.com',
            'subject' => 'Website support',
            'message' => 'I would like help with website updates.',
        ];
        $this->post(route('contact.store'), $data)->assertRedirect(route('contact-us'));
        $this->assertDatabaseHas('contact_enquiries', $data);
    }

    public function test_home_uses_latest_public_blog_records_and_editor_images(): void
    {
        $this->withoutVite();
        $common = [
            'excerpt' => 'An article excerpt',
            'content' => '<p>An article body</p>',
            'author_name' => 'Better Nexus',
            'is_published' => true,
        ];
        for ($i = 0; $i < 4; $i++) {
            Blog::create($common + [
                'title' => "Published entry {$i}", 'slug' => "published-entry-{$i}",
                'published_at' => now()->subDays(4 - $i),
                'featured_image' => "storage/blogs/cover-{$i}.webp",
            ]);
        }
        Blog::create(array_replace($common, [
            'title' => 'Unpublished test entry', 'slug' => 'unpublished-test-entry',
            'is_published' => false, 'published_at' => now()->subMinute(),
        ]));
        Blog::create($common + [
            'title' => 'Scheduled test entry', 'slug' => 'scheduled-test-entry',
            'published_at' => now()->addDay(),
        ]);
        $this->get(route('home'))->assertOk()
            ->assertSeeInOrder(['Published entry 3', 'Published entry 2', 'Published entry 1'])
            ->assertSee(route('blogs.show', 'published-entry-3'))
            ->assertSee('storage/blogs/cover-3.webp')
            ->assertDontSee('Published entry 0')
            ->assertDontSee('Unpublished test entry')
            ->assertDontSee('Scheduled test entry');
    }

    public function test_home_explains_empty_blog_section_and_uses_clean_video_only_hero(): void
    {
        $this->withoutVite();
        $this->get(route('home'))->assertOk()
            ->assertSee('No articles have been published yet')
            ->assertSee('Good questions. Clear answers.')
            ->assertSee('bn-clean-video-hero')
            ->assertSee('hero-mobile.webp')
            ->assertDontSee('va-video-control');
    }

    public function test_home_video_hero_has_no_promotional_text_or_buttons_and_uses_shared_header(): void
    {
        $this->withoutVite();
        $home = $this->get(route('home'))->assertOk()->assertSee('bn-clean-video-hero');
        $service = $this->get(route('services.index'))->assertOk();
        $this->assertStringContainsString('bn2-header bn-approved-header', $home->getContent());
        $this->assertStringContainsString('bn2-header bn-approved-header', $service->getContent());
        preg_match('~<section class="bn-clean-video-hero"[^>]*>(.*?)</section>~s', $home->getContent(), $matches);
        $this->assertNotEmpty($matches[1] ?? '');
        $this->assertDoesNotMatchRegularExpression('~<(?:h[1-6]|a|button)\b~i', $matches[1]);
        $this->assertStringContainsString('hero-mobile.webp', $matches[1]);
    }

    public function test_every_service_has_a_clickable_detail_page(): void
    {
        $this->withoutVite();
        $this->get(route('home'))->assertOk()->assertSee('Explore service');
        foreach (config('virtual-assistant') as $slug => $service) {
            $this->get(route('services.index'))->assertOk()
                ->assertSee(route('services.show', ['slug' => $slug]), false);
            $this->get(route('services.show', ['slug' => $slug]))->assertOk()
                ->assertSee($service['title'])
                ->assertSee($service['tasks'][0])
                ->assertSee('Discuss your requirements')
                ->assertSee('Explore related support');
        }
    }

    public function test_blog_cards_read_more_and_dynamic_detail_route_use_only_published_articles(): void
    {
        $this->withoutVite();
        $data = [
            'excerpt' => 'Advice for a successful handoff',
            'content' => 'A useful guide to delegation and virtual assistance.',
            'author_name' => 'Better Nexus',
            'category' => 'Delegation',
        ];
        $published = Blog::create($data + [
            'title' => 'Delegation made simple', 'slug' => 'delegation-made-simple',
            'is_published' => true, 'published_at' => now()->subDay(),
        ]);
        Blog::create($data + [
            'title' => 'Hidden draft article', 'slug' => 'hidden-draft-article',
            'is_published' => false, 'published_at' => now()->subDay(),
        ]);
        Blog::create($data + [
            'title' => 'Scheduled future article', 'slug' => 'scheduled-future-article',
            'is_published' => true, 'published_at' => now()->addDay(),
        ]);
        $this->get(route('blogs.index'))->assertOk()
            ->assertSee('Delegation made simple')
            ->assertSee('Read More')
            ->assertDontSee('Hidden draft article')
            ->assertDontSee('Scheduled future article');
        $this->get(route('blogs.show', ['slug' => $published->slug]))->assertOk()
            ->assertSee('A useful guide to delegation and virtual assistance.');
        $this->get(route('blogs.index', ['search' => 'unrelated']))->assertOk()
            ->assertDontSee('Delegation made simple');
    }
}
