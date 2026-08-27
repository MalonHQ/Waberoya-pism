<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            // Uhusiano na meza ya users (kwa mtumiaji mwenye role ya student)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Uhusiano na meza ya departments
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            
            $table->string('reg_number')->unique(); // Mfano: TSU/BIT/2025/001
            $table->string('phone_number')->nullable();
            $table->string('gender')->nullable(); // Male / Female
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};