<?php
namespace Database\Seeders;
use App\Models\Blog;
use Illuminate\Database\Seeder;
class BlogSeeder extends Seeder {public function run():void {$posts=json_decode(file_get_contents(database_path('seeders/data/better-nexus-blogs.json')),true,512,JSON_THROW_ON_ERROR);foreach($posts as $post)Blog::firstOrCreate(['slug'=>$post['slug']],$post);}}
