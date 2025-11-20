<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('campaign_name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->enum('category', ['infaq', 'sedekah', 'zakat', 'wakaf', 'qurban', 'renovation', 'program', 'other'])->default('infaq');
            $table->decimal('target_amount', 15, 2)->nullable();
            $table->decimal('current_amount', 15, 2)->default(0);
            $table->integer('donor_count')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_urgent')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->json('payment_methods')->nullable(); // Bank Transfer, QRIS, etc.
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
