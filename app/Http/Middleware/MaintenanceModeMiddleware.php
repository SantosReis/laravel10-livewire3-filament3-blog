<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Settings\GeneralSettings;

class MaintenanceModeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Skip maintenance mode for logged-in users (admin panel)
        if (auth()->check()) {
            return $next($request);
        }

        // Load maintenance setting from DB
        $settings = app(GeneralSettings::class);

        if ($settings->maintenance_mode) {
            // For JSON (AJAX/Livewire), return JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The site is under maintenance.',
                ], 503);
            }

            // For normal users, show maintenance view
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
