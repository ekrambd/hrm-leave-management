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
        Schema::create('ai_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leave_id')->constrained();
            $table->enum('type', ['positive', 'negative']);
            $table->text('ai_review');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_reviews');
    }
};
