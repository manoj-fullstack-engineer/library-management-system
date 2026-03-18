<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            'users' => ['view', 'create', 'edit', 'delete'],
            'roles' => ['view', 'create', 'edit', 'delete'],
            'permissions' => ['view', 'create', 'edit', 'delete'],
            'visitors' => ['view', 'create', 'edit', 'delete', 'export', 'print'],
            'enquiries' => ['view', 'create', 'edit', 'delete', 'export', 'print'],
            'categories' => ['view', 'create', 'edit', 'delete', 'export', 'print'],
            'books' => ['view', 'create', 'edit', 'delete', 'export', 'print'],
            'authors' => ['view', 'create', 'edit', 'delete', 'export', 'print'],
            'publishers' => ['view', 'create', 'edit', 'delete', 'export', 'print'],
            'students' => ['view', 'create', 'edit', 'delete', 'export', 'print'],
            'book-issues' => ['view', 'create', 'edit', 'delete', 'export', 'print'],
            'book-returns' => ['view', 'create', 'edit', 'delete', 'export', 'print'],
            'inventory-categories' => ['view', 'create', 'edit', 'delete', 'export', 'print'],
            'stocks' => ['view', 'create', 'edit', 'delete', 'export', 'print'],
            'vender bills' => ['view'],
            'library cards' =>['view', 'edit', 'create', 'delete', 'print', 'export'],
        ];

        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                $name = "{$action} {$module}";
                Permission::firstOrCreate(['name' => $name]);
            }
        }
    }
}
