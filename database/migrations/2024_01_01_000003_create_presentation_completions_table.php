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
        Schema::create('presentation_completions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->comment('Session identifier for tracking unique completions');
            $table->timestamp('completed_at')->useCurrent()->comment('When the presentation was completed');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('session_id');
            $table->index('completed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presentation_completions');
    }
};