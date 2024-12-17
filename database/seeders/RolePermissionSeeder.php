<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $renterRole = Role::firstOrCreate(['name' => 'renter', 'guard_name' => 'web']);
        $landlordRole = Role::firstOrCreate(['name' => 'landlord', 'guard_name' => 'web']);

        $Permissions = [
           'manage users',
           'manage ads',
           'manage reservations',
           'create reservation',
            'create review',
            'view all ads',
            'register ad',
            'view own ads',
            'download reports',
            'generate reports',
        ];


        foreach ($Permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $adminRole->givePermissionTo([
            'manage users', 
            'manage ads',
            'manage reservations',
        ]);

        $renterRole->givePermissionTo([
            'create reservation',
            'create review',
            'view all ads',
        ]);

        $landlordRole->givePermissionTo([
            'register ad',
            'view own ads',
            'download reports',
            'generate reports',
        ]);
    }
}
