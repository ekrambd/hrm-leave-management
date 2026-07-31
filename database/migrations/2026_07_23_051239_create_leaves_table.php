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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('employee_id')->constrained();
            $table->text('leave_reason');
            $table->text('leave_review')->nullable();
            $table->date('issue_date');
            $table->date('result_date')->nullable();
            $table->integer('leave_duration');
            $table->enum('type', ['sick', 'paid', 'unpaid', 'casual', 'special_consideration']);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
