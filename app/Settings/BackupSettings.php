<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class BackupSettings extends Settings
{
    public bool $auto_backup_enabled;
    public string $backup_frequency;
    public ?string $notification_email;
    public int $keep_backups_for_days;

    public static function group(): string
    {
        return 'backup';
    }

    public static function getDefaults(): array
    {
        return [
            'auto_backup_enabled' => true,
            'backup_frequency' => 'daily',
            'notification_email' => '',
            'keep_backups_for_days' => 7,
        ];
    }
}
