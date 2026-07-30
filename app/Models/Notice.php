<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'file_path',
        'status',
        'user_id',
    ];

    /**
     * Get the user that authored the notice.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
