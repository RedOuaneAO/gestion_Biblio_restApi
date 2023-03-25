<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions(); 

        // Create permissions for books
        Permission::create(['name' => 'show every Book']);
        Permission::create(['name' => 'show Book']);
        Permission::create(['name' => 'add book']);
        Permission::create(['name' => 'edit every book']);
        Permission::create(['name' => 'edit my book']);
        Permission::create(['name' => 'delete every book']);
        Permission::create(['name' => 'delete my book']);

        // Create permissions for Categories
        Permission::create(['name' => 'show categories']);
        Permission::create(['name' => 'show category']);
        Permission::create(['name' => 'add category']);
        Permission::create(['name' => 'edit category']);
        Permission::create(['name' => 'delete category']);

        Role::create(['name' => 'admin'])
            ->givePermissionTo(Permission::all());

        Role::create(['name' => 'receptionist'])
            ->givePermissionTo(
                'add book',
                'edit my book',
                'delete my book',
                'show every Book',
                'show Book',
                // 'edit my profile',
                // 'delete my profile'
            );

        // Role::create(['name' => 'user'])
        //     ->givePermissionTo(
        //         'edit my profile',
        //         'delete my profile'
        //     );
    }
}
