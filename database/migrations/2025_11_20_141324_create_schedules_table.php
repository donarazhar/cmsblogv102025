<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['prayer', 'event', 'class', 'other'])->default('event');
            $table->date('date')->nullable(); // For specific date events
            $table->enum('day_of_week', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])->nullable();
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('location')->nullable();
            $table->string('imam')->nullable(); // For prayer schedules
            $table->string('speaker')->nullable(); // For events/classes
            $table->enum('frequency', ['once', 'daily', 'weekly', 'monthly'])->default('once');
            $table->boolean('is_recurring')->default(false);
            $table->string('color', 7)->default('#0053C5');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['type', 'date']);
            $table->index(['day_of_week', 'is_recurring']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
