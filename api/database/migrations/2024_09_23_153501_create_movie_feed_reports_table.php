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
        Schema::create('movie_feed_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('max_result');
            $table->integer('start_index');
            $table->integer('movies_count');
            $table->integer('countries_count');
            $table->float('average_actors_count');
            $table->integer('subscription_movies_count');
            $table->integer('purchase_movies_count');
            $table->json('movies_by_country');
            $table->json('genre_stats');
            $table->json('top_keywords');
            $table->json('movies_by_year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_feed_reports');
    }
};
