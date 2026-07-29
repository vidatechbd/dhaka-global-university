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
        Schema::table('certificates', function (Blueprint $table) {
            $table->string('department')->nullable()->after('description');
            $table->string('father_name')->nullable()->after('department');
            $table->string('mother_name')->nullable()->after('father_name');
            $table->string('course_name')->nullable()->after('mother_name');
            $table->string('exam_roll')->nullable()->after('course_name');
            $table->string('reg_no')->nullable()->after('exam_roll');
            $table->string('session')->nullable()->after('reg_no');
            $table->string('credit_completed')->nullable()->after('session');
            $table->string('credit_total')->nullable()->after('credit_completed');
            $table->string('result')->nullable()->after('credit_total');
            $table->json('semesters')->nullable()->after('result');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn([
                'department',
                'father_name',
                'mother_name',
                'course_name',
                'exam_roll',
                'reg_no',
                'session',
                'credit_completed',
                'credit_total',
                'result',
                'semesters',
            ]);
        });
    }
};
