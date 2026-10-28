<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * SEO keyword mapping (requirements doc): every indexable page carries a
     * focus keyword, 2-4 long-tail keywords and 2-4 secondary keywords, all
     * editable from admin. Semicolon-separated strings keep the admin form
     * simple; the front end only reads them for reference/meta keywords.
     */
    public function up(): void
    {
        Schema::table('page_metas', function (Blueprint $table) {
            $table->string('focus_keyword')->nullable()->after('meta_description');
            $table->text('long_tail_keywords')->nullable()->after('focus_keyword');
            $table->text('secondary_keywords')->nullable()->after('long_tail_keywords');
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->string('focus_keyword')->nullable()->after('meta_description');
            $table->text('long_tail_keywords')->nullable()->after('focus_keyword');
            $table->text('secondary_keywords')->nullable()->after('long_tail_keywords');
        });
    }

    public function down(): void
    {
        Schema::table('page_metas', function (Blueprint $table) {
            $table->dropColumn(['focus_keyword', 'long_tail_keywords', 'secondary_keywords']);
        });
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropColumn(['focus_keyword', 'long_tail_keywords', 'secondary_keywords']);
        });
    }
};
