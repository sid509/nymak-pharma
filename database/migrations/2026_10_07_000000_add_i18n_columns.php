<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Per-record translations for the public site (en/fr/es). One `i18n` JSON
 * column per translatable table; structure {locale: {field: value}}.
 */
return new class extends Migration
{
    private array $tables = [
        'product_categories',
        'products',
        'markets',
        'posts',
        'faqs',
        'team_members',
        'testimonials',
        'page_contents',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->json('i18n')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropColumn('i18n');
            });
        }
    }
};
