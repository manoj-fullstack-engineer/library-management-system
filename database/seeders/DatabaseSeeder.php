<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class, // Always create Roles first
            UserSeeder::class, // Then create Users and assign roles
            PermissionSeeder::class, // Then create Permissions 
            VisitorSeeder::class,
            
        ]);
    }
}
