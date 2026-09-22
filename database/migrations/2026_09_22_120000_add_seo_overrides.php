<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('markets', function (Blueprint $table) {
            $table->string('meta_title')->nullable()->after('sort_order');
            $table->string('meta_description', 300)->nullable()->after('meta_title');
        });

        // Per-page SEO overrides for static/list pages — rows are keyed to a
        // fixed set of public pages and edited from /admin/seo-pages.
        Schema::create('page_metas', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 300)->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('markets', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description']);
        });
        Schema::dropIfExists('page_metas');
    }
};
