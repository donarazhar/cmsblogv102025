<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ad_banners', function (Blueprint $table) {
            $table->text('target_routes')->nullable()->after('url_link')->comment('Comma separated routes where banner should appear. Empty means only homepage slider.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ad_banners', function (Blueprint $table) {
            $table->dropColumn('target_routes');
        });
    }
};
