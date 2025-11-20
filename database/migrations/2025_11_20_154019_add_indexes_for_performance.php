<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Helper function to check if index exists
        $indexExists = function ($table, $indexName) {
            $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
            return !empty($indexes);
        };

        // Posts indexes
        Schema::table('posts', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('posts', 'posts_status_published_at_is_featured_index')) {
                $table->index(['status', 'published_at', 'is_featured'], 'posts_status_published_at_is_featured_index');
            }
            // Skip category_id index karena sudah ada
        });

        // Programs indexes
        Schema::table('programs', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('programs', 'programs_is_active_is_featured_order_index')) {
                $table->index(['is_active', 'is_featured', 'order'], 'programs_is_active_is_featured_order_index');
            }
        });

        // Galleries indexes
        Schema::table('galleries', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('galleries', 'galleries_is_active_is_featured_type_index')) {
                $table->index(['is_active', 'is_featured', 'type'], 'galleries_is_active_is_featured_type_index');
            }
        });

        // Schedules indexes
        Schema::table('schedules', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('schedules', 'schedules_is_active_type_date_index')) {
                $table->index(['is_active', 'type', 'date'], 'schedules_is_active_type_date_index');
            }
        });

        // Donations indexes
        Schema::table('donations', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('donations', 'donations_is_active_is_featured_end_date_index')) {
                $table->index(['is_active', 'is_featured', 'end_date'], 'donations_is_active_is_featured_end_date_index');
            }
        });

        // Testimonials indexes
        Schema::table('testimonials', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('testimonials', 'testimonials_status_is_featured_index')) {
                $table->index(['status', 'is_featured'], 'testimonials_status_is_featured_index');
            }
        });

        // Staff indexes
        Schema::table('staff', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('staff', 'staff_is_active_is_featured_order_index')) {
                $table->index(['is_active', 'is_featured', 'order'], 'staff_is_active_is_featured_order_index');
            }
        });

        // Categories indexes
        Schema::table('categories', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('categories', 'categories_is_active_order_index')) {
                $table->index(['is_active', 'order'], 'categories_is_active_order_index');
            }
        });

        // Sliders indexes
        Schema::table('sliders', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('sliders', 'sliders_is_active_order_index')) {
                $table->index(['is_active', 'order'], 'sliders_is_active_order_index');
            }
        });

        // Announcements indexes
        Schema::table('announcements', function (Blueprint $table) use ($indexExists) {
            if (!$indexExists('announcements', 'announcements_is_active_show_on_homepage_index')) {
                $table->index(['is_active', 'show_on_homepage'], 'announcements_is_active_show_on_homepage_index');
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex('posts_status_published_at_is_featured_index');
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->dropIndex('programs_is_active_is_featured_order_index');
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropIndex('galleries_is_active_is_featured_type_index');
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropIndex('schedules_is_active_type_date_index');
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->dropIndex('donations_is_active_is_featured_end_date_index');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropIndex('testimonials_status_is_featured_index');
        });

        Schema::table('staff', function (Blueprint $table) {
            $table->dropIndex('staff_is_active_is_featured_order_index');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('categories_is_active_order_index');
        });

        Schema::table('sliders', function (Blueprint $table) {
            $table->dropIndex('sliders_is_active_order_index');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropIndex('announcements_is_active_show_on_homepage_index');
        });
    }
};
