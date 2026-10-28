<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        if(Schema::hasTable('blogs') && Schema::hasColumn('blogs','excerpt')) {
            Schema::table('blogs', fn(Blueprint $table)=>$table->text('excerpt')->nullable()->change());
        }
    }
    public function down(): void { /* Never truncate existing rich content by narrowing back to VARCHAR. */ }
};
