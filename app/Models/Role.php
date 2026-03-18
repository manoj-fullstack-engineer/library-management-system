<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends SpatieRole
{
    use HasFactory;
    protected $fillable = ['name', 'guard_name'];
    protected $casts = [
        'created_at' => 'datetime:d/m/Y',
        'updated_at' => 'datetime:d/m/Y',
    ];

    // In your Role model
    protected static function booted()
    {
        static::updated(function ($role) {
            Cache::forget("role_permissions_{$role->id}");
            Cache::forget("role_user_count_{$role->id}");
        });
    }
    
}
