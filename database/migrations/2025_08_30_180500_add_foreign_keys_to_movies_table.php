<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            // Ensure the columns exist and add foreign key constraints now that referenced tables exist
            $table->foreign('director_artist_id')
                ->references('id')->on('artists')
                ->restrictOnDelete();

            $table->foreign('country_id')
                ->references('id')->on('countries')
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropForeign(['director_artist_id']);
            $table->dropForeign(['country_id']);
        });
    }
};
