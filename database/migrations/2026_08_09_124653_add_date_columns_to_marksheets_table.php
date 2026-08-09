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
        Schema::table('marksheets', function (Blueprint $table) {
            $table->date('date_of_issue')->nullable()->after('result');
            $table->date('result_published')->nullable()->after('date_of_issue');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marksheets', function (Blueprint $table) {
            $table->dropColumn(['date_of_issue', 'result_published']);
        });
    }
};
