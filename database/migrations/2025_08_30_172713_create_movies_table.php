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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->text('description')->nullable();
            $table->string('image');
            $table->string('IMDB')->nullable();
            $table->string('IMDB_link')->nullable();
            $table->string('trailer')->nullable();
            $table->string('rank')->default(0);
            $table->string('year')->default(0);
            $table->bigInteger('duration')->default(0);
            $table->bigInteger('director_artist_id');
            $table->bigInteger('country_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
