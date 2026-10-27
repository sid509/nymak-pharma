<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('markets', function (Blueprint $table) {
            $table->string('pin_type', 20)->default('partner')->after('region');
        });

        // The map is now a pinboard, not a globe - refresh the seeded slot copy
        // only where it still holds the old seed text (admin edits are kept).
        // The branded-grid toggle is likewise flipped only from the stale
        // seed '0' to the approved '1'.
        DB::table('page_contents')
            ->where('page', 'home')->where('key', 'show_brands')->where('value', '0')
            ->update(['value' => '1']);

        $copy = [
            'map_title' => ['One supply line from Mundra to the world', 'Every pin on the board is a working market'],
            'map_lead' => ['Every arc on the globe is a live supply route from our Mundra facility. Drag to spin, click a highlighted country, or pick from the list, to see the work, the products and the people on the ground.', 'Each pin marks a market we supply today: gold for our own offices, blue for ethical markets, green for partner markets. Click a pin, or pick from the list, to see the work, the products and the people on the ground.'],
            'map_empty_title' => ['Spin the globe, pick a country', 'Pick a pin, explore a market'],
            'map_empty_body' => ['Highlighted countries are where we export today. Select one to read what we do there and which products we supply.', 'The pins mark where we export today. Select one to read what we do there and which products we supply.'],
        ];
        foreach ($copy as $key => [$old, $new]) {
            DB::table('page_contents')
                ->where('page', 'markets.index')->where('key', $key)->where('value', $old)
                ->update(['value' => $new]);
        }
    }

    public function down(): void
    {
        Schema::table('markets', function (Blueprint $table) {
            $table->dropColumn('pin_type');
        });
    }
};
