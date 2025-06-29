<?php

namespace Database\Seeders\Admin;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Permission::create(['guard_name'=>'admin','name'=>'user-index','group_name'=>'User Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'user-create','group_name'=>'User Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'user-update','group_name'=>'User Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'user-delete','group_name'=>'User Permissions']);


        // Permission::create(['guard_name'=>'admin','name'=>'role-permission-index','group_name'=>'Roles And Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'role-permission-create','group_name'=>'Roles And Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'role-permission-update','group_name'=>'Roles And Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'role-permission-delete','group_name'=>'Roles And Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'specific-permission-create','group_name'=>'Roles And Permissions']);


        // Permission::create(['guard_name'=>'admin','name'=>'language-index','group_name'=>'Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'language-create','group_name'=>'Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'language-update','group_name'=>'Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'language-delete','group_name'=>'Language Permissions']);


        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-generate','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-translate','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-update','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-string-index','group_name'=>'Backend Language Permissions']);
        // Permission::create(['guard_name'=>'admin','name'=>'backend-api-accesskey','group_name'=>'Backend Language Permissions']);


        // Permission::create(['guard_name'=>'admin','name'=>'maintenance-mode-index','group_name'=>'Settings Permissions']);

        // Permission::create(['guard_name'=>'admin','name'=>'room-index','group_name'=>'Rooms']);
        // Permission::create(['guard_name'=>'admin','name'=>'room-create','group_name'=>'Rooms']);
        // Permission::create(['guard_name'=>'admin','name'=>'room-update','group_name'=>'Rooms']);
        // Permission::create(['guard_name'=>'admin','name'=>'room-delete','group_name'=>'Rooms']);


        // Permission::create(['guard_name'=>'admin','name'=>'hostel-index','group_name'=>'Hosteles']);
        // Permission::create(['guard_name'=>'admin','name'=>'hostel-create','group_name'=>'Hosteles']);
        // Permission::create(['guard_name'=>'admin','name'=>'hostel-update','group_name'=>'Hosteles']);
        // Permission::create(['guard_name'=>'admin','name'=>'hostel-delete','group_name'=>'Hosteles']);


        // Permission::create(['guard_name'=>'admin','name'=>'seat-index','group_name'=>'Seats']);
        // Permission::create(['guard_name'=>'admin','name'=>'seat-create','group_name'=>'Seats']);
        // Permission::create(['guard_name'=>'admin','name'=>'seat-update','group_name'=>'Seats']);
        // Permission::create(['guard_name'=>'admin','name'=>'seat-delete','group_name'=>'Seats']);


        Permission::create(['guard_name'=>'admin','name'=>'booking-index','group_name'=>'Booking']);
        Permission::create(['guard_name'=>'admin','name'=>'booking-create','group_name'=>'Booking']);
        Permission::create(['guard_name'=>'admin','name'=>'booking-update','group_name'=>'Booking']);
        Permission::create(['guard_name'=>'admin','name'=>'booking-delete','group_name'=>'Booking']);
    }
}
