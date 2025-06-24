<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleTableSeeder extends Seeder
{
    public function run(): void
    {
        // Clear permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = [
            'Super Admin',
            'Admin',
            'Editor',
            'Customer',
            'Agent',
        ];

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Optional: Assign all permissions to Super Admin
            if ($roleName === 'Super Admin') {
                $role->syncPermissions(Permission::all());
            }

            // Optional: Assign limited permissions to Admin
            if ($roleName === 'Admin') {
                $role->syncPermissions([
                    'dashboard-access',
                    'user-view',
                    'user-create',
                    'user-edit',
                    'user-delete',
                    'role-view',
                    'role-create',
                ]);
            }

            // You can add logic for Editor, Customer, Agent similarly
        }
    }
}
