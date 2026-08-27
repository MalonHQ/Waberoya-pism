<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Uhusiano na Wasifu wa Mwanafunzi (StudentProfile)
    public function studentProfile()
    {
        return $this->belongsTo(StudentProfile::class, 'student_profile_id');
    }

    // Uhusiano na Somo (Course)
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}