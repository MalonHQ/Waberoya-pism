<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Mfano: 2025/2026
            $table->boolean('is_active')->default(false); // Mwaka unaoendelea hivi sasa
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_years');
    }
};