<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Content policy: no em/en dashes in user-visible copy. Materialized rows
     * (translations, earlier seeds, admin edits) keep whatever characters they
     * were written with, so sweep them here rather than trusting every seeder
     * path to have run since.
     */
    public function up(): void
    {
        $columns = [
            'page_contents' => ['value', 'i18n'],
            'posts' => ['title', 'excerpt', 'body', 'meta_title', 'meta_description', 'i18n'],
            'faqs' => ['question', 'answer', 'i18n'],
            'markets' => ['name', 'description', 'meta_title', 'meta_description', 'content', 'i18n'],
            'product_categories' => ['name', 'intro', 'description', 'meta_title', 'meta_description', 'content', 'i18n'],
            'products' => ['name', 'therapeutic_group', 'strength', 'pack_size', 'specimen', 'description', 'meta_title', 'meta_description', 'i18n'],
            'client_logos' => ['name'],
            'journey_items' => ['title', 'body', 'i18n'],
            'testimonials' => ['name', 'country', 'quote', 'i18n'],
            'team_members' => ['name', 'role', 'bio', 'meta_title', 'meta_description', 'i18n'],
            'certifications' => ['name', 'issuer', 'description'],
            'site_settings' => ['value'],
            'page_metas' => ['meta_title', 'meta_description'],
        ];

        foreach ($columns as $table => $cols) {
            $rows = DB::table($table)->get();
            foreach ($rows as $row) {
                $dirty = [];
                foreach ($cols as $col) {
                    $v = $row->{$col} ?? null;
                    if (is_string($v) && (str_contains($v, "\u{2013}") || str_contains($v, "\u{2014}"))) {
                        $dirty[$col] = str_replace(["\u{2013}", "\u{2014}"], '-', $v);
                    }
                }
                if ($dirty) {
                    DB::table($table)->where('id', $row->id)->update($dirty);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
