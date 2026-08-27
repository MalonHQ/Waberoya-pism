<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $role = $data['role'] ?? null;
        unset($data['role']);

        // 1. Mtengeneze mtumiaji kwanza
        $user = static::getModel()::create($data);

        // 2. Mpatie role kwa njia salama zaidi
        if ($role) {
            try {
                $user->assignRole(strtolower(trim($role)));
            } catch (\Exception $e) {
                // Kama kuna tatizo limetokea kwenye role, angalau mtumiaji anatengenezwa bila kusababisha crash
            }
        }

        return $user;
    }
}