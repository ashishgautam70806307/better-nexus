<?php

namespace Tests\Feature;

use Tests\TestCase;

class BetterNexusFrontendTest extends TestCase
{
    public function test_all_frontend_pages_render(): void
    {
        $this->withoutVite();
        foreach (['home', 'about', 'contact-us', 'services.index', 'blogs.index'] as $name) {
            $this->get(route($name))->assertOk()->assertSee('Better Nexus');
        }
        foreach (array_keys(config('frontend.services')) as $slug) {
            $this->get(route('services.show', ['slug' => $slug]))->assertOk()->assertSee('bn6-service');
        }
        foreach (array_keys(config('frontend.blogs')) as $slug) {
            $this->get(route('blogs.show', ['slug' => $slug]))->assertOk();
        }
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
        $this->get('/case-studies/not-an-article')->assertNotFound();
    }

    public function test_navigation_has_one_blogs_link_and_no_case_studies_label(): void
    {
        $this->withoutVite();
        $response = $this->get(route('home'))->assertOk()->assertDontSee('Case Studies');
        $html = $response->getContent();
        preg_match('/<nav class="bn2-nav"[^>]*>(.*?)<\/nav>/s', $html, $matches);
        $this->assertSame(1, substr_count($matches[1] ?? '', route('blogs.index')));
    }
}
