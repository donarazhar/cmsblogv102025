<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('image');
            $table->string('mobile_image')->nullable(); // Responsive image for mobile
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->string('button_text_2')->nullable();
            $table->string('button_link_2')->nullable();
            $table->enum('text_position', ['left', 'center', 'right'])->default('center');
            $table->string('overlay_color', 7)->default('#000000');
            $table->integer('overlay_opacity')->default(50); // 0-100
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
