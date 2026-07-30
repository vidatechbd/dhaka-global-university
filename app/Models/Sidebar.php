<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sidebar extends Model
{
    protected $fillable = ['name'];

    public function contents()
    {
        return $this->hasMany(SidebarContent::class)->orderBy('sort_order');
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }
}
