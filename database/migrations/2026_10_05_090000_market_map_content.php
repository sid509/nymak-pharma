<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('markets', function (Blueprint $table) {
            // Rich "what we do here" panel shown when a country is selected on
            // the Global Presence map. Sanitised HTML authored in the admin
            // WYSIWYG; `description` stays as the short plain summary.
            $table->longText('content')->nullable()->after('description');
            // Pin position for markets that are not a single ISO country
            // (e.g. "South Pacific Islands") — or to override the centroid.
            $table->decimal('latitude', 8, 5)->nullable()->after('content');
            $table->decimal('longitude', 8, 5)->nullable()->after('latitude');
        });
    }

    public function down(): void
    {
        Schema::table('markets', function (Blueprint $table) {
            $table->dropColumn(['content', 'latitude', 'longitude']);
        });
    }
};
