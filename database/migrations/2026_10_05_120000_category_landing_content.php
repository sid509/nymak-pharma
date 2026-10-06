<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            // Category pages are content landing pages now (the product list
            // moved to /product/{category}/products). Sanitised WYSIWYG HTML.
            $table->longText('content')->nullable()->after('description');
            $table->string('image')->nullable()->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropColumn(['content', 'image']);
        });
    }
};
