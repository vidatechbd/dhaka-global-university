<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage roles',
            'manage teachers',
            'manage students',
            'create marksheet',
            'view marksheet',
            'create certificate',
            'view certificate',
            'manage news',
            'create news',
            'edit news',
            'delete news',
            'view news',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $principalRole = Role::firstOrCreate(['name' => 'Principal']);
        $principalRole->syncPermissions($permissions); // Principal has all permissions

        $teacherRole = Role::firstOrCreate(['name' => 'Teacher']);
        $teacherRole->syncPermissions([
            'manage students',
            'create marksheet',
            'view marksheet',
            'create certificate',
            'view certificate',
            'manage news',
            'create news',
            'edit news',
            'delete news',
            'view news',
        ]);

        $studentRole = Role::firstOrCreate(['name' => 'Student']);
        $studentRole->syncPermissions([
            'view marksheet',
            'view certificate',
            'view news',
        ]);

        // Create default Principal user
        $principal = User::firstOrCreate(
            ['email' => 'principal@university.com'],
            [
                'name' => 'Default Principal',
                'password' => Hash::make('password'),
                'status' => 'active',
            ]
        );

        if (! $principal->hasRole('Principal')) {
            $principal->assignRole($principalRole);
        }
    }
}
