<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kutengeneza Roles 3 za Mfumo
        $adminRole    = Role::firstOrCreate(['name' => 'admin']);
        $lecturerRole = Role::firstOrCreate(['name' => 'lecturer']);
        $studentRole  = Role::firstOrCreate(['name' => 'student']);

        // 2. Admin (Mratibu Mkuu)
        $admin = User::firstOrCreate(
            ['email' => 'admin@waberoya.co.tz'],
            [
                'name'     => 'Mratibu Mkuu',
                'password' => Hash::make('Waberoya@2027'),
            ]
        );
        $admin->assignRole($adminRole);

        // 3. Lecturer (Enerico Sumbizi)
        $lecturer = User::firstOrCreate(
            ['email' => 'mbizisu@gmail.com'],
            [
                'name'     => 'Enerico Sumbizi',
                'password' => Hash::make('Enerico@2027'),
            ]
        );
        $lecturer->assignRole($lecturerRole);

        // 4. Student (Malon Sumbizi)
        $student = User::firstOrCreate(
            ['email' => 'malonsumbizi@gmail.com'],
            [
                'name'     => 'Malon Sumbizi',
                'password' => Hash::make('Sumbizi@2027'),
            ]
        );
        $student->assignRole($studentRole);
    }
}