<?php

namespace App\Filament\Resources\StudentProfileResource\Pages;

use App\Filament\Resources\StudentProfileResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class CreateStudentProfile extends CreateRecord
{
    protected static string $resource = StudentProfileResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // 1. Tunatengeneza User kwanza kwenye meza ya users
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // 2. Tunampa moja kwa moja jukumu la student
        $user->assignRole('student');

        // 3. Tunatengeneza StudentProfile na kumunganisha na huyu user
        return static::getModel()::create([
            'user_id' => $user->id,
            'department_id' => $data['department_id'],
            'reg_number' => $data['reg_number'],
            'gender' => $data['gender'],
            'phone_number' => $data['phone_number'] ?? null,
            'address' => $data['address'] ?? null,
        ]);
    }
}