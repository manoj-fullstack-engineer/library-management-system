<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

function run(): void
{
    $superAdmin = Role::findByName('SuperAdmin');
    $admin = Role::findByName('Admin');
    $manager = Role::findByName('Manager');

    $permissions = Permission::pluck('name')->toArray();

    $superAdmin->syncPermissions($permissions);
    $admin->syncPermissions([
        'view visitors',
        'create visitors',
        'edit visitors',
        'delete visitors',
        'export visitors',
        'print visitors'
    ]);

    $manager->syncPermissions([
        'view visitors',
        'export visitors',
        'print visitors'
    ]);
}
