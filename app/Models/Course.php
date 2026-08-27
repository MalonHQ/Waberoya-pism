<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'user_id',
        'code',
        'title',
        'credits',
        'description',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ONGEZA HII: Uhusiano na meza ya Enrollments
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }
}