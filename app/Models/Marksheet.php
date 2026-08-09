<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'student_id',
    'student_name',
    'title',
    'description',
    'created_by',
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
    'date_of_issue',
    'result_published',
    'semesters',
])]
class Marksheet extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'semesters' => 'array',
            'date_of_issue' => 'date',
            'result_published' => 'date',
        ];
    }

    /**
     * Get the student that owns the marksheet.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the teacher/principal who created the marksheet.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
