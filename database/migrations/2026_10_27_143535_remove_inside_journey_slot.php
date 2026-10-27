<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * The Inside page's story rail now renders the shared journey_items
     * timeline - the old inside.journey content slot is retired.
     */
    public function up(): void
    {
        DB::table('page_contents')->where('page', 'inside')->where('key', 'journey')->delete();
    }

    public function down(): void
    {
        //
    }
};
