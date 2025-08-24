<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateBackupSystemSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('backup.auto_backup_enabled', true);
        $this->migrator->add('backup.backup_frequency', 'daily');
        $this->migrator->add('backup.notification_email', '');
        $this->migrator->add('backup.keep_backups_for_days', 7);
    }
}
