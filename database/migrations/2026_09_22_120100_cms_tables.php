<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Per-slot content overrides for public pages. Empty rows fall back to
        // the defaults declared in PageContent::SCHEMA.
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('page');
            $table->string('key');
            $table->longText('value')->nullable();
            $table->timestamps();
            $table->unique(['page', 'key']);
        });

        // Company facts (NAP, socials, stats, offices) — flat keys merged over
        // config/nymak.php defaults via SiteSetting::merged().
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->timestamps();
        });

        Schema::create('client_logos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_contents');
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('client_logos');
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }
};
