<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void { if (!Schema::hasTable('blogs')) Schema::create('blogs',function(Blueprint $t){
 $t->id();$t->string('title');$t->string('slug')->unique();$t->string('category')->nullable();$t->text('excerpt')->nullable();$t->string('featured_image')->nullable();$t->longText('content');$t->string('author_name')->default('Better Nexus');$t->string('meta_title')->nullable();$t->text('meta_description')->nullable();$t->boolean('is_published')->default(false);$t->timestamp('published_at')->nullable();$t->timestamps();$t->index(['is_published','published_at']);
 }); }
 public function down(): void { /* Compatibility migration: canonical create migration owns this table. */ }
};
