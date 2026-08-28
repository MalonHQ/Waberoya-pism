<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Uhusiano na Profaili ya Mwanafunzi (Kama ni mwanafunzi)
     */
    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class);
    }

    /**
     * Ulinzi wa Filament Panels kulingana na Role ya User
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // 1. Master admin au mwenye role ya admin anapita popote moja kwa moja
        if ($this->email === 'admin@waberoya.co.tz' || $this->hasRole('admin')) {
            return true;
        }

        // 2. Kwenye mlango mkuu wa Admin (fomu yetu ya pamoja ya login)
        if ($panel->getId() === 'admin') {
            return $this->hasRole('admin') || $this->hasRole('lecturer') || $this->hasRole('student');
        }

        // 3. Ruhusu lecturer kwenye panel yake
        if ($panel->getId() === 'lecturer') {
            return $this->hasRole('lecturer');
        }

        // 4. Ruhusu student kwenye panel yake
        if ($panel->getId() === 'student') {
            return $this->hasRole('student');
        }

        return false;
    }
}