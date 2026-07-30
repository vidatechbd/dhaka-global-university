<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSetting extends Model
{
    protected $fillable = [
        'show_top_bar',
        'top_bar_email',
        'top_bar_phone',
        'top_bar_links',
        'show_hero',
        'hero_slides',
        'hero_tag',
        'hero_title',
        'hero_description',
        'hero_btn_text_1',
        'hero_btn_url_1',
        'hero_btn_text_2',
        'hero_btn_url_2',
        'show_about',
        'about_tag',
        'about_title',
        'about_description',
        'about_years',
        'about_image',
        'about_url',
        'show_leadership',
        'leadership_title',
        'leadership_description',
        'leadership_members',
        'show_faculties',
        'faculties_title',
        'faculties_btn_text',
        'faculties_btn_url',
        'faculties',
        'show_news_notice',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'top_bar_links' => 'array',
            'hero_slides' => 'array',
            'leadership_members' => 'array',
            'faculties' => 'array',
            'show_top_bar' => 'boolean',
            'show_hero' => 'boolean',
            'show_about' => 'boolean',
            'show_leadership' => 'boolean',
            'show_faculties' => 'boolean',
            'show_news_notice' => 'boolean',
        ];
    }
}
