<?php
namespace Tests\Feature;
use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class BlogModuleTest extends TestCase {
 use RefreshDatabase;
 private function post(array $changes=[]):Blog{return Blog::create(array_merge(['title'=>'A better story','slug'=>'a-better-story','excerpt'=>'Introduction','content'=>'Full story','author_name'=>'Better Nexus','is_published'=>true,'published_at'=>now()->subMinute()],$changes));}
 public function test_published_article_is_visible():void{$b=$this->post();$this->get(route('blogs.index'))->assertOk()->assertSee($b->title);$this->get(route('blogs.show',$b->slug))->assertOk()->assertSee('Full story');}
 public function test_draft_and_future_articles_are_hidden():void{foreach([['slug'=>'draft','is_published'=>false],['slug'=>'future','published_at'=>now()->addDay()]] as $d){$b=$this->post($d);$this->get(route('blogs.show',$b->slug))->assertNotFound();}}
 public function test_admin_requires_login():void{$this->get(route('admin.blogs.index'))->assertRedirect(route('login'));}
 public function test_search_filters_articles():void{$this->post();$this->get(route('blogs.index',['search'=>'unmatched']))->assertOk()->assertDontSee('A better story');}
}
