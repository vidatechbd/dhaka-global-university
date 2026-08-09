<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'student_id',
    'name',
    'roll',
    'reg_no',
    'subject',
    'cgpa',
    'out_of',
    'date_of_issue',
    'result_published',
    'created_by',
])]
class Certificate extends Model
{
    protected $casts = [
        'date_of_issue' => 'date',
        'result_published' => 'date',
    ];

    /**
     * Get the student that owns the certificate.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the teacher/principal who created the certificate.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
