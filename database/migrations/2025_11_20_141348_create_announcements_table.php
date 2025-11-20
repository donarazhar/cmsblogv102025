<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->enum('type', ['info', 'warning', 'success', 'danger'])->default('info');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->string('icon')->nullable();
            $table->string('link')->nullable();
            $table->string('link_text')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->boolean('show_on_homepage')->default(true);
            $table->boolean('show_popup')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
