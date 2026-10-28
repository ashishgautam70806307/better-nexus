<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration {
    public function up(): void
    {
        Schema::create("home_heroes", function (Blueprint $table) {
            $table->id();
            $table->string("eyebrow", 150)->nullable();
            $table->string("title", 180);
            $table->string("highlight", 180)->nullable();
            $table->text("description")->nullable();
            $table->string("primary_label", 70)->nullable();
            $table->string("primary_url", 1000)->nullable();
            $table->string("secondary_label", 70)->nullable();
            $table->string("secondary_url", 1000)->nullable();
            $table->boolean("is_active")->default(true);
            $table->boolean("show_video")->default(false);
            $table->timestamps();
        });
        Schema::create("home_hero_images", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("home_hero_id")
                ->constrained("home_heroes")
                ->cascadeOnDelete();
            $table->string("path");
            $table->string("alt", 180)->nullable();
            $table->unsignedSmallInteger("sort_order")->default(0);
            $table->boolean("is_active")->default(true);
            $table->timestamps();
            $table->index(["home_hero_id", "sort_order"]);
        });
        DB::table("home_heroes")->insert([
            "id" => 1,
            "eyebrow" => "GREAT PEOPLE. MEANINGFUL CONNECTIONS.",
            "title" => "Great talent.",
            "highlight" => "Better possibilities.",
            "description" =>
                "Specialist skills. Seamless support. More space for your business to grow.",
            "primary_label" => "Explore our services",
            "primary_url" => "/services",
            "secondary_label" => "Talk to our team",
            "secondary_url" => "/contact-us",
            "is_active" => true,
            "show_video" => false,
            "created_at" => now(),
            "updated_at" => now(),
        ]);
        // Keep the existing design populated without copying or deleting shared assets.
        foreach (
            [
                "administration",
                "support",
                "marketing",
                "creative",
                "software",
                "engineering",
            ]
            as $i => $name
        ) {
            DB::table("home_hero_images")->insert([
                "home_hero_id" => 1,
                "path" => "better-nexus/assets/bn2/" . $name . ".jpg",
                "alt" => ucfirst($name) . " specialist",
                "sort_order" => $i,
                "is_active" => true,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }
    }
    public function down(): void
    {
        Schema::dropIfExists("home_hero_images");
        Schema::dropIfExists("home_heroes");
    }
};
