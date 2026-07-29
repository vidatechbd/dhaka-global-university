 <?php

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

test('roles and permissions can be created and assigned to users', function () {
    // Create a role and a permission
    $role = Role::create(['name' => 'admin']);
    $permission = Permission::create(['name' => 'edit articles']);

    // Give permission to the role
    $role->givePermissionTo($permission);

    // Create a user and assign the role
    $user = User::factory()->create();
    $user->assignRole($role);

    // Assert user has the role and permission
    expect($user->hasRole('admin'))->toBeTrue()
        ->and($user->hasPermissionTo('edit articles'))->toBeTrue();
});
