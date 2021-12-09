<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'team.create',
            'display_name' => 'Create Teams',
            'description' => 'create new teams',
        ]);

        Permission::create([
            'name' => 'team.view',
            'display_name' => 'View Teams',
            'description' => 'can see the teams',
        ]);

        Permission::create([
            'name' => 'team.update',
            'display_name' => 'Edit Teams',
            'description' => 'can edit a team',
        ]);

        Permission::create([
            'name' => 'user.create',
            'display_name' => 'Create User',
            'description' => 'create a new user',
        ]);

        Permission::create([
            'name' => 'user.view',
            'display_name' => 'View User',
            'description' => 'can see the user',
        ]);

        Permission::create([
            'name' => 'user.update',
            'display_name' => 'Edit User',
            'description' => 'can edit a user',
        ]);

        // create an administrator role as standard
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Admin', // optional
            'description' => 'User is an administrator', // optional
        ]);

        $admin->attachPermissions(Permission::all());
    }
}
