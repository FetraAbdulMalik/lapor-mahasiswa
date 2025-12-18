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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nim', 20)->unique();
            $table->foreignId('faculty_id')->constrained();
            $table->foreignId('department_id')->constrained();
            $table->integer('semester')->default(1);
            $table->year('year_of_entry');
            $table->enum('status', ['active', 'inactive', 'graduated', 'leave'])->default('active');
            $table->string('avatar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};