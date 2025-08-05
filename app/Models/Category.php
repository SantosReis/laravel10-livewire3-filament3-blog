<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'text_color',
        'bg_color',
    ];

    public $translatable = ['title', 'slug'];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function getLocalizedTitleAttribute(): ?string
    {
        return $this->title[app()->getLocale()] ?? $this->title['en'] ?? null;
    }

    public function getLocalizedSlugAttribute()
    {
        return $this->slug[app()->getLocale()] ?? $this->slug['en'] ?? null;
    }
}
