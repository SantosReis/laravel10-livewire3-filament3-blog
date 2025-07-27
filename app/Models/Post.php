<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'image',
        'body',
        'published_at',
        'featured',
    ];

    protected $casts = [
        'title' => 'array',
        'slug' => 'array',
        'body' => 'array',
        'published_at' => 'datetime',
    ];

    protected static function booted()
    {
    static::saved(function () {
        Cache::forget('featuredPosts');
        Cache::forget('latestPosts');
    });

    static::deleted(function () {
        Cache::forget('featuredPosts');
        Cache::forget('latestPosts');
    });
}

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_like')->withTimestamps();
    }

    public function scopePublished($query)
    {
        $query->where('published_at', '>=', Carbon::now());
    }

    public function scopeWithCategory($query, string $category)
    {
        $query->whereHas('categories', function ($query) use ($category) {
            $query->where('slug', $category);
        });
    }

    public function scopeFeatured($query)
    {
        $query->where('featured', true);
    }

    public function scopePopular($query)
    {
        $query->withCount('likes')
            ->orderBy("likes_count", 'desc');
    }

    public function scopeSearch($query, string $search = '')
    {
        $query->where('title', 'like', "%{$search}%");
    }

    public function getExcerpt(): string
    {
        $body = $this->body[app()->getLocale()] ?? $this->body['en'] ?? '';
        return Str::limit(strip_tags($body), 250);
    }

    public function getReadingTime(): int
    {
        $body = $this->body[app()->getLocale()] ?? $this->body['en'] ?? '';
        $mins = round(str_word_count(strip_tags($body)) / 250);

        return ($mins < 1) ? 1 : $mins;
    }

    public function getThumbnailUrl()
    {
        $isUrl = str_contains($this->image, 'http');

        return ($isUrl) ? $this->image : Storage::disk('public')->url($this->image);
    }

    //may should be removed...
    // public function getSlugAttribute($value)
    // {
    //     return json_decode($value ?? '{}', true);
    // }

    public function getLocalizedTitleAttribute(): ?string
    {
        return $this->title[app()->getLocale()] ?? $this->title['en'] ?? null;
    }
    public function getLocalizedSlugAttribute()
    {
        return $this->slug[app()->getLocale()] ?? $this->slug['en'];
    }

    public function getLocalizedBodyAttribute(): string
    {
        $body = $this->body[app()->getLocale()] ?? $this->body['en'] ?? '';
        return strip_tags($body);
    }

}
