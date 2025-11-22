<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop foreign key temporarily
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });

        // Modify ENUM to add 'private'
        DB::statement("ALTER TABLE pages MODIFY COLUMN status ENUM('draft', 'published', 'private') DEFAULT 'published'");

        // Re-add foreign key
        Schema::table('pages', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });

        DB::statement("ALTER TABLE pages MODIFY COLUMN status ENUM('draft', 'published') DEFAULT 'published'");

        Schema::table('pages', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }
};