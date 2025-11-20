<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('programs', 'content')) {
                $table->text('content')->nullable()->after('description');
            }
            if (!Schema::hasColumn('programs', 'icon')) {
                $table->string('icon', 100)->nullable()->after('image');
            }
            if (!Schema::hasColumn('programs', 'organizer')) {
                $table->string('organizer')->nullable()->after('max_participants');
            }
            if (!Schema::hasColumn('programs', 'speaker')) {
                $table->string('speaker')->nullable()->after('organizer');
            }
            if (!Schema::hasColumn('programs', 'contact_person')) {
                $table->string('contact_person')->nullable()->after('speaker');
            }
            if (!Schema::hasColumn('programs', 'contact_phone')) {
                $table->string('contact_phone', 20)->nullable()->after('contact_person');
            }
            if (!Schema::hasColumn('programs', 'order')) {
                $table->integer('order')->default(0)->after('contact_phone');
            }
            if (!Schema::hasColumn('programs', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_active');
            }
            if (!Schema::hasColumn('programs', 'is_registration_open')) {
                $table->boolean('is_registration_open')->default(true)->after('is_featured');
            }
        });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $columns = [
                'content', 
                'icon', 
                'organizer', 
                'speaker', 
                'contact_person', 
                'contact_phone', 
                'order', 
                'is_featured', 
                'is_registration_open'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('programs', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};