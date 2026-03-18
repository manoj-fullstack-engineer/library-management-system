<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    // You can customize here if needed.
    // For example, mass assignable attributes or relationships

    protected $fillable = [
        'name',
        'guard_name',
    ];

    // Example: You could define relationships like this:
    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }
}
