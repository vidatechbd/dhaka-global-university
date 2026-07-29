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
        Schema::create('university_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Dhaka Global University');
            $table->text('address')->nullable();
            $table->json('contacts')->nullable();
            $table->json('social_medias')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('university_settings');
    }
};
