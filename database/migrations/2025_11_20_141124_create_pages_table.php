<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->string('template')->default('default'); // default, about, contact, custom
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->boolean('show_in_menu')->default(false);
            $table->integer('menu_order')->default(0);
            $table->foreignId('parent_id')->nullable()->constrained('pages')->onDelete('cascade');
            $table->string('icon')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->json('custom_fields')->nullable(); // For flexible content
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
