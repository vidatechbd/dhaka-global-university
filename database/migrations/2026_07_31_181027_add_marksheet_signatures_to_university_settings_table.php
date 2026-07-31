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
            $table->string('marksheet_prepared_by')->nullable()->after('signature');
            $table->string('marksheet_compared_by')->nullable()->after('marksheet_prepared_by');
            $table->string('marksheet_controller_signature')->nullable()->after('marksheet_compared_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('university_settings', function (Blueprint $table) {
            $table->dropColumn([
                'marksheet_prepared_by',
                'marksheet_compared_by',
                'marksheet_controller_signature',
            ]);
        });
    }
};
