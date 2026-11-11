<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('home_heroes', function (Blueprint $table) {
            $table->string('desktop_video_path')->nullable();
            $table->string('mobile_video_path')->nullable();
            $table->boolean('desktop_video_published')->default(false);
            $table->boolean('mobile_video_published')->default(false);
        });
    }
    public function down(): void {
        Schema::table('home_heroes', function (Blueprint $table) {
            $table->dropColumn(['desktop_video_path','mobile_video_path','desktop_video_published','mobile_video_published']);
        });
    }
};
