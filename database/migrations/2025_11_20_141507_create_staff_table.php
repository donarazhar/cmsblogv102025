<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('position');
            $table->string('department')->nullable();
            $table->enum('type', ['board', 'imam', 'teacher', 'staff', 'volunteer'])->default('staff');
            $table->text('biography')->nullable();
            $table->string('photo')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('specialization')->nullable(); // For imams/teachers
            $table->json('social_media')->nullable(); // Facebook, Instagram, Twitter, etc.
            $table->date('join_date')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
