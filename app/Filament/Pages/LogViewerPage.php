<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class LogViewerPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $title = 'Logs';
    protected static ?string $navigationLabel = 'Logs';

    protected static ?string $slug = 'logs';

    protected static ?int $navigationSort = 2; // optional, order in menu

    protected static string $view = 'filament.pages.log-viewer-page';
}
