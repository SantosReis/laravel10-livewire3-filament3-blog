<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        if (isset($data['slug']) && is_array($data['slug'])) {
            $data['slug'] = array_filter($data['slug'], fn ($value) => ! empty($value));
        }

        return $data;
    }
}
