<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Pages\Actions\Action;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view')
                ->label('View Post')
                ->icon('heroicon-o-arrow-top-right-on-square')
                // ->url(fn () => url('/blog/' . $this->record->slug))
                ->url(fn () => url('/blog/' . ($this->record->slug['en'] ?? '')))
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // $locales = array_keys(config('app.supported_locales'));

        // foreach ($locales as $locale) {
        //     $data['slug'][$locale] ??= $data['slug']['en'] ?? '';
        //     $data['title'][$locale] ??= $data['title']['en'] ?? '';
        //     $data['body'][$locale] ??= $data['body']['en'] ?? '';
        // }

        if (isset($data['slug']) && is_array($data['slug'])) {
            $data['slug'] = array_filter($data['slug'], fn ($value) => !empty($value));
        }

        return $data;
    }
}
