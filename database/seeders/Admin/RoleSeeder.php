<?php

namespace Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $role = Role::create(['guard_name'=>'admin','name'=>'Super Admin']);
       $role = Role::create(['guard_name'=>'admin','name'=>'Admin']);
    //    $role->syncPermissions(['user-index','user-create','user-update','user-delete']);
    }
}
