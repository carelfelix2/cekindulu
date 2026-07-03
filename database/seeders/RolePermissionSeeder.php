<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage users',
            'manage products',
            'manage marketplaces',
            'manage affiliate links',
            'manage transactions',
            'manage memberships',
            'manage rewards',
            'manage settings',
            'view admin dashboard',
            'approve rewards',
            'approve transactions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign all permissions to admin
        $adminRole->givePermissionTo(Permission::all());

        // Migrate existing users to use Spatie roles
        // Users with role='admin' get admin role
        User::where('role', 'admin')->each(function ($user) use ($adminRole) {
            if (!$user->hasRole('admin')) {
                $user->assignRole($adminRole);
            }
        });

        // All other users get user role
        User::where('role', '!=', 'admin')->orWhereNull('role')->each(function ($user) use ($userRole) {
            if (!$user->hasRole('user')) {
                $user->assignRole($userRole);
            }
        });

        // Create default admin if none exists
        $adminExists = User::role('admin')->exists();
        if (!$adminExists) {
            $admin = User::firstOrCreate(
                ['email' => 'admin@cekdulu.com'],
                [
                    'name' => 'Admin CekDulu',
                    'password' => bcrypt('password'),
                    'role' => 'admin',
                    'email_verified_at' => now(),
                ]
            );
            $admin->assignRole($adminRole);
        }
    }
}
