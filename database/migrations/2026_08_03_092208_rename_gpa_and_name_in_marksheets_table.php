<?php

use App\Models\Marksheet;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update JSON key 'gpa' to 'year_cgp' and 'name' to 'year' in semesters JSON column
        foreach (Marksheet::all() as $marksheet) {
            $semesters = $marksheet->semesters;
            if (is_array($semesters)) {
                $updated = [];
                foreach ($semesters as $sem) {
                    if (isset($sem['name'])) {
                        $sem['year'] = $sem['name'];
                        unset($sem['name']);
                    }
                    if (isset($sem['gpa'])) {
                        $sem['year_cgp'] = $sem['gpa'];
                        unset($sem['gpa']);
                    }
                    $updated[] = $sem;
                }
                $marksheet->semesters = $updated;
                $marksheet->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach (Marksheet::all() as $marksheet) {
            $semesters = $marksheet->semesters;
            if (is_array($semesters)) {
                $updated = [];
                foreach ($semesters as $sem) {
                    if (isset($sem['year'])) {
                        $sem['name'] = $sem['year'];
                        unset($sem['year']);
                    }
                    if (isset($sem['year_cgp'])) {
                        $sem['gpa'] = $sem['year_cgp'];
                        unset($sem['year_cgp']);
                    }
                    $updated[] = $sem;
                }
                $marksheet->semesters = $updated;
                $marksheet->save();
            }
        }
    }
};
