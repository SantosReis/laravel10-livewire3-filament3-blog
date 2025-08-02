<?php

namespace App\Filament\Pages;

use Filament\Pages\SettingsPage;
use App\Settings\GeneralSettings;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;

class GeneralSettingsPage extends SettingsPage
{

    protected static ?string $title = 'General Settings';
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static string $settings = GeneralSettings::class;
    protected static ?string $navigationGroup = 'Settings';

    public function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('site_name')->label('Site Name')->required(),
                Toggle::make('maintenance_mode')->label('Maintenance Mode'),
            ]);
    }

}
