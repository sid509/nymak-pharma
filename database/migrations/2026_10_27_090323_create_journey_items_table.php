<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journey_items', function (Blueprint $table) {
            $table->id();
            $table->string('year', 20);
            $table->string('title', 160);
            $table->text('body')->nullable();
            $table->string('icon', 60)->nullable();
            $table->string('image')->nullable();
            $table->string('image_2')->nullable();
            $table->string('fit', 10)->default('cover');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->json('i18n')->nullable();
            $table->timestamps();
        });

        // The timeline now lives in journey_items (admin CRUD) - the old
        // JSON slot is superseded.
        DB::table('page_contents')->where('page', 'about')->where('key', 'timeline')->delete();
    }

    public function down(): void
    {
        Schema::dropIfExists('journey_items');
    }
};
