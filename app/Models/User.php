<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Filament admin panel access
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasAnyRole(['Admin', 'Editor']);
    }

    // Relations
    public function likes()
    {
        return $this->belongsToMany(Post::class, 'post_like')->withTimestamps();
    }

    public function hasLiked(Post $post): bool
    {
        return $this->likes()->where('post_id', $post->id)->exists();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Optional: profile photo
    public function getProfilePhotoUrlAttribute(): ?string
    {
        // Example: fallback to gravatar if no photo
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email)));
    }
}
