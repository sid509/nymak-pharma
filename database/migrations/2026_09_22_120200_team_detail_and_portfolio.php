<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
            $table->text('bio')->nullable()->after('photo');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
        });

        // Markets no longer get standalone pages — they appear as portfolio
        // entries on /global-presence instead.
        Schema::table('markets', function (Blueprint $table) {
            $table->renameColumn('has_page', 'show_in_portfolio');
        });
    }

    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn(['slug', 'bio', 'meta_title', 'meta_description']);
        });
        Schema::table('markets', function (Blueprint $table) {
            $table->renameColumn('show_in_portfolio', 'has_page');
        });
    }
};
