<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            
            // 1. Uhusiano na Idara (Department)
            $table->foreignId('department_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // 2. Uhusiano na Mwalimu (User mwenye role ya Lecturer)
            $table->foreignId('user_id')
                ->nullable()
                ->comment('Lecturer assigned to course')
                ->constrained('users')
                ->nullOnDelete();

            $table->string('code')->unique(); // Mfano: CS101, BIT204
            $table->string('title');       // Mfano: Introduction to Programming
            $table->integer('credits')->default(3); // Idadi ya kozi / Units
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};