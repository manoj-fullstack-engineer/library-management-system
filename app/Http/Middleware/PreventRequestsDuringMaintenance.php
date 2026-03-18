<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * The URIs that should be reachable while maintenance mode is active.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Example: 'api/health-check',
    ];
}
