<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        if(!Schema::hasTable('home_heroes')||!Schema::hasTable('home_hero_images'))return;
        DB::transaction(function() {
            $hero=DB::table('home_heroes')->where('id',1)->lockForUpdate()->first();
            if(!$hero || (string)$hero->created_at!==(string)$hero->updated_at)return;
            $expected=array_map(fn($name)=>'better-nexus/assets/bn2/'.$name.'.jpg',['administration','support','marketing','creative','software','engineering']);
            $paths=DB::table('home_hero_images')->where('home_hero_id',1)->orderBy('sort_order')->orderBy('id')->pluck('path')->all();
            if($paths!==$expected)return;
            for($i=1;$i<=5;$i++) {
                DB::table('home_hero_images')->insert([
                    'home_hero_id'=>1,'path'=>'better-nexus/assets/images/portraits/portrait-'.str_pad((string)$i,2,'0',STR_PAD_LEFT).'.webp',
                    'alt'=>'','sort_order'=>$i+5,'is_active'=>true,'created_at'=>now(),'updated_at'=>now(),
                ]);
            }
            DB::table('home_heroes')->where('id',1)->update([
                'show_video'=>true,'secondary_label'=>null,'secondary_url'=>null,
                'description'=>"Specialist skills. Seamless support.\nMore space for your business to grow.",'updated_at'=>now(),
            ]);
        });
    }
    // This correction never deletes images or restores obsolete settings on rollback.
    public function down(): void {}
};
