<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Optional: Truncate the table before seeding fresh data
        Schema::disableForeignKeyConstraints();
        Permission::truncate();
        Schema::enableForeignKeyConstraints();

        // Clear the cached permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permission names
        $permissions = [
            // User Management
            'user-menu',
            'user-create',
            'user-edit',
            'user-delete',
            'user-view',

            // Role Management
            'role-menu',
            'role-create',
            'role-edit',
            'role-delete',
            'role-view',

            // Product Management
            'product-menu',
            'product-create',
            'product-edit',
            'product-delete',
            'product-view',

            // Orders & Dashboard
            'order-manage',
            'dashboard-access',
        ];

        // Create each permission with the 'web' guard
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }
    }
}
