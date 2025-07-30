<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Models\Post;
use Filament\Actions;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // $locales = array_keys(config('app.supported_locales'));

        // foreach ($locales as $locale) {
        //     // Fallback to English if not filled
        //     $data['slug'][$locale] ??= $data['slug']['en'] ?? '';
        //     $data['title'][$locale] ??= $data['title']['en'] ?? '';
        //     $data['body'][$locale] ??= $data['body']['en'] ?? '';
        // }

        if (isset($data['slug']) && is_array($data['slug'])) {
            $data['slug'] = array_filter($data['slug'], fn ($value) => !empty($value));
        }


        return $data;
    }

    protected function handleRecordCreation(array $data): Post
    {
        $tagIds = is_array($data['tags'] ?? null) ? $data['tags'] : [];
        unset($data['tags']);

        $locale = config('app.fallback_locale');

        $tagNames = \Spatie\Tags\Tag::whereIn('id', $tagIds)
            ->get()
            ->map(fn ($tag) => $tag->getTranslation('name', $locale))
            ->toArray();

        $post = static::getModel()::create($data);
        $post->syncTags($tagNames);

        return $post;
    }
}
