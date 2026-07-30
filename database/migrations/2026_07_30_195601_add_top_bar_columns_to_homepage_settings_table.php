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
        Schema::table('homepage_settings', function (Blueprint $table) {
            $table->boolean('show_top_bar')->default(true)->after('id');
            $table->string('top_bar_email')->nullable()->after('show_top_bar');
            $table->string('top_bar_phone')->nullable()->after('top_bar_email');
            $table->json('top_bar_links')->nullable()->after('top_bar_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homepage_settings', function (Blueprint $table) {
            $table->dropColumn(['show_top_bar', 'top_bar_email', 'top_bar_phone', 'top_bar_links']);
        });
    }
};
