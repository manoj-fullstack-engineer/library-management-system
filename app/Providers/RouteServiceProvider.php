<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Path to redirect users after login.
     */
    public const HOME = '/home'; // <-- Add this line ✅

    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
        // Route::model('role', \Spatie\Permission\Models\Role::class);
    }
}
