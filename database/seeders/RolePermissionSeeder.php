<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin', 'description' => 'Administrator']);
        $landlordRole = Role::create(['name' => 'landlord', 'description' => 'Landlord']);
        $renterRole = Role::create(['name' => 'renter', 'description' => 'Renter']);

        $manageUsersPermission = Permission::create(['name' => 'manage_users', 'description' => 'Manage users']);
        $viewPropertiesPermission = Permission::create(['name' => 'view_properties', 'description' => 'View properties']);
        $editPropertiesPermission = Permission::create(['name' => 'edit_properties', 'description' => 'Edit properties']);

        $adminRole->permissions()->attach([$manageUsersPermission->id, $viewPropertiesPermission->id, $editPropertiesPermission->id]);
        $landlordRole->permissions()->attach([$viewPropertiesPermission->id, $editPropertiesPermission->id]);
        $renterRole->permissions()->attach([$viewPropertiesPermission->id]);
    }
}
