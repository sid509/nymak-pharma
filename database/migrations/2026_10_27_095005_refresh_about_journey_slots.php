<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * The journey heading slots were seeded with the old copy before the
     * reference design landed. Refresh rows that still hold the seeded
     * defaults - real admin edits are left alone.
     */
    public function up(): void
    {
        $swaps = [
            'journey_eyebrow' => ['Our Journey', 'Since 1998'],
            'journey_title' => ['Milestones that shaped Nymak', 'Our Journey'],
        ];

        foreach ($swaps as $key => [$old, $new]) {
            DB::table('page_contents')
                ->where('page', 'about')->where('key', $key)->where('value', $old)
                ->update(['value' => $new]);
        }
    }

    public function down(): void
    {
        //
    }
};
