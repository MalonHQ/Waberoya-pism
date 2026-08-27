<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->decimal('ca_marks', 5, 2)->default(0); // Alama za mazoezi / Tests
            $table->decimal('exam_marks', 5, 2)->default(0); // Alama za mtihani wa mwisho
            $table->decimal('total_marks', 5, 2)->default(0); // Jumla ya alama
            $table->string('grade')->nullable(); // Daraja (A, B, C, etc.)
            $table->string('status')->default('pending'); // Hali: pending au approved
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};