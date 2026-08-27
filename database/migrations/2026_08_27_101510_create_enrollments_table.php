<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            // Uhusiano na Profaili ya Mwanafunzi
            $table->foreignId('student_profile_id')->constrained()->cascadeOnDelete();
            // Uhusiano na Somo (Course)
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            // Uhusiano na Muhula (Semester) ili kujua alisoma muhula gani
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            
            // HIZI NDIZO ZILIKUWA ZINAKOSEKANA:
            $table->decimal('cat_marks', 5, 2)->nullable();
            $table->decimal('exam_marks', 5, 2)->nullable();
            $table->decimal('total_marks', 5, 2)->nullable();
            $table->string('grade', 5)->nullable();

            $table->string('status')->default('enrolled'); // Mfano: enrolled, completed, dropped
            $table->timestamps();

            // Kuzuia mwanafunzi asijisajili somo lile lile mara mbili kwenye semester moja
            // $table->unique(['student_profile_id', 'course_id', 'semester_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};