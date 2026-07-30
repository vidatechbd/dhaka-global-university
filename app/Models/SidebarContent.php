<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SidebarContent extends Model
{
    protected $fillable = [
        'sidebar_id',
        'title',
        'type',
        'content',
        'sort_order',
    ];

    public function sidebar()
    {
        return $this->belongsTo(Sidebar::class);
    }

    /**
     * Get link list if type is links.
     */
    public function getLinksAttribute(): array
    {
        if ($this->type === 'links' && ! empty($this->content)) {
            return json_decode($this->content, true) ?: [];
        }

        return [];
    }
}
