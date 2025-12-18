<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number', 20)->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained('report_categories');
            $table->string('title');
            $table->text('description');
            $table->string('location')->nullable();
            $table->foreignId('building_id')->nullable()->constrained();
            $table->foreignId('facility_id')->nullable()->constrained();
            $table->date('incident_date')->nullable();
            $table->enum('status', ['pending', 'in_review', 'in_progress', 'resolved', 'rejected'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('visibility', ['public', 'anonymous', 'private'])->default('public');
            $table->boolean('is_anonymous')->default(false);
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->integer('views_count')->default(0);
            $table->timestamps();
            
            $table->index(['status', 'created_at']);
            $table->index('reference_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};