<?php

namespace App\Http\Controllers\Admin; // Wait, this is the model file!

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniversitySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'established_year',
        'contacts',
        'social_medias',
        'logo',
        'controller_of_examinations',
        'marksheet_prepared_by',
        'marksheet_compared_by',
        'marksheet_controller_signature',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_author',
        'favicon',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'contacts' => 'array',
            'social_medias' => 'array',
        ];
    }
}
