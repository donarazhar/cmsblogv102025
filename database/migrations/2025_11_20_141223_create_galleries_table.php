<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('thumbnail')->nullable();
            $table->enum('type', ['image', 'video'])->default('image');
            $table->string('video_url')->nullable(); // YouTube/Vimeo URL
            $table->foreignId('album_id')->nullable()->constrained('gallery_albums')->onDelete('cascade');
            $table->foreignId('program_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
