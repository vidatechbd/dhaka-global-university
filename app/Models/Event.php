<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'thumbnail',
        'status',
        'user_id',
    ];

    /**
     * Get the user who authored the event.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
