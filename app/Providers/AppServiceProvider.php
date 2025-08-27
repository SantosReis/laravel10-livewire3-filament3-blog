<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict();
        Model::shouldBeStrict($this->app->isProduction());
        // DB::prohibitDestructiveCommands($this->app->isProduction()); //laravel 11+

        if ($this->app->environment('production')) {
            if (app()->runningUnitTests() || app()->runningInConsole() && in_array('test', request()->server('argv', []))) {
                exit("Tests are disabled in production environment.\n");
            }
        }

        // Paginator::defaultView('vendor.pagination.custom');
        Paginator::defaultView('vendor.pagination.custom'); // for regular links
        Paginator::defaultSimpleView('vendor.pagination.custom'); // for simple links

    }
}
