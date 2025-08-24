<?php

namespace App\Filament\Pages;

use App\Settings\BackupSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class ManageBackup extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $title = 'Backup Management';
    protected static ?string $navigationLabel = 'Backups';
    protected static string $settings = BackupSettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Backup Settings')
                    ->schema([
                        Forms\Components\Toggle::make('auto_backup_enabled')
                            ->label('Enable Automatic Backups')
                            ->helperText('Automatically run backups based on the frequency setting'),

                        Forms\Components\Select::make('backup_frequency')
                            ->label('Backup Frequency')
                            ->options([
                                'daily' => 'Daily',
                                'weekly' => 'Weekly',
                                'monthly' => 'Monthly',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('notification_email')
                            ->label('Notification Email')
                            ->email()
                            ->helperText('Email address to receive backup notifications'),

                        Forms\Components\TextInput::make('keep_backups_for_days')
                            ->label('Keep Backups For (Days)')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(365)
                            ->required(),
                    ]),

                Forms\Components\Section::make('Manual Backup Actions')
                    ->schema([
                        Forms\Components\Placeholder::make('manual_actions')
                            ->label('')
                            ->content('Use the actions above to manually create or download backups.'),
                    ]),

                Forms\Components\Section::make('Available Backups')
                    ->schema([
                        Forms\Components\Placeholder::make('backup_list')
                            ->label('')
                            ->content(view('filament.pages.backup-list', [
                                'backups' => $this->getAvailableBackups()
                            ])),
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('backup_database')
                ->label('Backup Database')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    try {
                        $exitCode = Artisan::call('backup:run', ['--only-db' => true]);
                        $output = Artisan::output();
                        logger()->info("Backup exit: $exitCode, output: $output");
                        // Artisan::call('backup:run', ['--only-db' => true, '--force' => true]);

                        Notification::make()
                            ->title('Database Backup Created!')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Backup Failed')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
                ->requiresConfirmation()
                ->modalHeading('Create Database Backup')
                ->modalDescription('This will create a backup of your database. Continue?'),

            Action::make('backup_files')
                ->label('Backup Files')
                ->icon('heroicon-o-folder-arrow-down')
                ->color('info')
                ->action(function () {
                    try {
                        Artisan::call('backup:run', ['--only-files' => true]);

                        Notification::make()
                            ->title('Files Backup Created')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Backup Failed')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
                ->requiresConfirmation(),

            Action::make('full_backup')
                ->label('Full Backup')
                ->icon('heroicon-o-server-stack')
                ->color('warning')
                ->action(function () {
                    try {
                        Artisan::call('backup:run');

                        Notification::make()
                            ->title('Full Backup Created')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Backup Failed')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
                ->requiresConfirmation(),

            Action::make('download_latest')
                ->label('Download Latest')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->action(function () {
                    return $this->downloadLatestBackup();
                }),

            Action::make('cleanup')
                ->label('Cleanup Old Backups')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->action(function () {
                    try {
                        Artisan::call('backup:clean');

                        Notification::make()
                            ->title('Old Backups Cleaned')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Cleanup Failed')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
                ->requiresConfirmation(),
        ];
    }

    protected function getAvailableBackups(): array
    {

        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $files = $disk->allFiles(config('backup.backup.name'));

        return collect($files)
            ->filter(fn ($file) => str_ends_with($file, '.zip'))
            ->map(function ($file) use ($disk) {
                return [
                    'name' => basename($file),
                    'size' => $this->formatBytes($disk->size($file)),
                    'date' => $disk->lastModified($file)
                        ? date('Y-m-d H:i:s', $disk->lastModified($file))
                        : null,
                    'path' => $file,
                ];
            })
            ->values()
            ->toArray();
    }

    protected function downloadLatestBackup()
    {

        $backups = $this->getAvailableBackups();

        if (empty($backups)) {
            Notification::make()
                ->title('No Backups Available')
                ->body('Please create a backup first.')
                ->warning()
                ->send();
            return;
        }

        $latestBackup = $backups[0];

        $fullPath = storage_path('app/spatie-backup/' . $latestBackup['name']);

        if (!file_exists($fullPath)) {
            Notification::make()
                ->title('File Not Found')
                ->body("The file {$latestBackup['name']} does not exist.")
                ->danger()
                ->send();
            return;
        }

        return response()->download($fullPath, $latestBackup['name']);

    }

    public function downloadBackup(string $filename)
    {

        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $path = config('backup.backup.name') . '/' . $filename;

        if (! $disk->exists($path)) {
            Notification::make()
                ->title('Backup not found')
                ->danger()
                ->send();
            return redirect()->back(); // optional, avoids blank response
        }

        return response()->streamDownload(function () use ($disk, $path) {
            echo $disk->get($path);
        }, $filename);

    }

    protected function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = ['B', 'KB', 'MB', 'GB', 'TB'];

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }

}
