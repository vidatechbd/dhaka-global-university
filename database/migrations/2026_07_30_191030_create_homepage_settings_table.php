<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('homepage_settings', function (Blueprint $table) {
            $table->id();

            // Hero section
            $table->boolean('show_hero')->default(true);
            $table->json('hero_slides')->nullable();
            $table->string('hero_tag')->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_btn_text_1')->nullable();
            $table->string('hero_btn_url_1')->nullable();
            $table->string('hero_btn_text_2')->nullable();
            $table->string('hero_btn_url_2')->nullable();

            // About section
            $table->boolean('show_about')->default(true);
            $table->string('about_tag')->nullable();
            $table->string('about_title')->nullable();
            $table->text('about_description')->nullable();
            $table->string('about_years')->nullable();
            $table->string('about_image')->nullable();
            $table->string('about_url')->nullable();

            // Leadership section
            $table->boolean('show_leadership')->default(true);
            $table->string('leadership_title')->nullable();
            $table->text('leadership_description')->nullable();
            $table->json('leadership_members')->nullable();

            // Faculties section
            $table->boolean('show_faculties')->default(true);
            $table->string('faculties_title')->nullable();
            $table->string('faculties_btn_text')->nullable();
            $table->string('faculties_btn_url')->nullable();
            $table->json('faculties')->nullable();

            // News & Notice section toggle
            $table->boolean('show_news_notice')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_settings');
    }
};
