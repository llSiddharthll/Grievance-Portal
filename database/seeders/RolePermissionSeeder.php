<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Permissions list
        $permissions = [
            'complaints.view',
            'complaints.create',
            'complaints.edit',
            'complaints.delete',
            'complaints.assign',
            'complaints.resolve',
            'officers.manage',
            'users.manage',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles with permissions
        $roles = [
            'admin' => [
                'complaints.view',
                'complaints.create',
                'complaints.edit',
                'complaints.delete',
                'complaints.assign',
                'officers.manage',
                'users.manage'
            ],
            'officer' => [
                'complaints.view',
                'complaints.resolve'
            ],
            'citizen' => [
                // public users take no system permissions
            ],
        ];

        // Assign permissions to each role
        foreach ($roles as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Attach permissions
            if (!empty($perms)) {
                $role->syncPermissions($perms);
            }
        }
    }
}
