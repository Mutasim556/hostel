<?php

namespace Database\Seeders\Admin;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new Admin();
        // $admin->name = 'Mutasim';
        // $admin->email = 'admin@admin.com';
        // $admin->phone = '01724698392';
        // $admin->username = 'mutasim';
        // $admin->password = Hash::make('admin');
        // $admin->save();
        // $admin->assignRole('Super Admin');

        $admin->name = 'admin';
        $admin->email = 'admin@admin.com';
        $admin->phone = '01724698393';
        $admin->username = 'admin';
        $admin->password = Hash::make('admin');
        $admin->save();
        $admin->assignRole('Super Admin');
    }
}
