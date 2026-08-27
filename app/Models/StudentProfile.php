<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'reg_number',
        'phone_number',
        'gender',
        'address',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Uhusiano sahihi wa department kulingana na muundo wa database yako
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'student_profile_id');
    }
}