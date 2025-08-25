<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use App\Enums\UserRole;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count()),
            Stat::make('Total Admins', User::role(UserRole::ADMIN)->count()),
            Stat::make('Total Editors', User::role(UserRole::EDITOR)->count()),
        ];
    }
}
