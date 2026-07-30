<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'program_type',
        'admission_type',
        'ssc_or_equivalent',
        'ssc_division_or_gpa',
        'hsc_or_equivalent',
        'hsc_division_or_gpa',
        'bachelor_or_degree_hons',
        'bachelor_division_or_gpa',
        'status',
        'user_id',
    ];

    /**
     * Get the user account created for the student.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
