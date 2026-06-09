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
        Schema::create('survey_follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained('survey_periods')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('action_plan')->nullable();
            $table->string('responsible_unit')->nullable();
            $table->string('PIC')->nullable();
            $table->date('target_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->enum('priority', ['high', 'medium', 'low'])->default('medium');
            $table->text('result')->nullable();
            $table->string('document_path')->nullable();
            $table->timestamps();
            
            // Index
            $table->index('period_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_follow_ups');
    }
};
