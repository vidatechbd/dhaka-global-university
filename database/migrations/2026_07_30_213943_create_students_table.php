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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile');
            $table->string('email');
            $table->string('program_type');
            $table->string('admission_type');
            $table->string('ssc_or_equivalent');
            $table->string('ssc_division_or_gpa');
            $table->string('hsc_or_equivalent');
            $table->string('hsc_division_or_gpa');
            $table->string('bachelor_or_degree_hons')->nullable();
            $table->string('bachelor_division_or_gpa')->nullable();
            $table->string('status')->default('pending'); // pending, approved
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
