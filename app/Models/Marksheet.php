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
