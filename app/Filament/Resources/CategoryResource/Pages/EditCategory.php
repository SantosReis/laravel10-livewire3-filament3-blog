<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Pages\Actions\Action;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view')
                ->label('View Post')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn () => url('/blog?category=' . $this->record->slug))
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {

        if (isset($data['slug']) && is_array($data['slug'])) {
            $data['slug'] = array_filter($data['slug'], fn ($value) => !empty($value));
        }

        return $data;
    }
}
