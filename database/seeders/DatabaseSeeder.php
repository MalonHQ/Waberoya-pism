<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Hakikisha Roles zote za mfumo zimesajiliwa kwanza kwenye Database
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'lecturer']);
        Role::firstOrCreate(['name' => 'student']);

        // 2. Kutengeneza au kusasisha Admin Rasmi
        $admin = User::updateOrCreate(
            ['email' => 'admin@waberoya.co.tz'],
            [
                'name' => 'Waberoya Admin',
                'password' => Hash::make('Waberoya@2027'),
            ]
        );

        // 3. Mpatie role ya admin kama hana
        if (!$admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }
    }
}