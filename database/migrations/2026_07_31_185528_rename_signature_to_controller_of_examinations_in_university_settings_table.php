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
        Schema::table('university_settings', function (Blueprint $table) {
            $table->renameColumn('signature', 'controller_of_examinations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('university_settings', function (Blueprint $table) {
            $table->renameColumn('controller_of_examinations', 'signature');
        });
    }
};
