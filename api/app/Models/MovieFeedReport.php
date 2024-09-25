<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $max_result
 * @property int $start_index
 * @property int $movies_count
 * @property int $average_actors_count
 * @property int $subscription_movies_count
 * @property int $purchase_movies_count
 * @property int $movies_by_country
 * @property array $genre_stats
 * @property array $top_keywords
 * @property array $movies_by_year
 */
class MovieFeedReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'max_result',
        'start_index',
        'movies_count',
        'countries_count',
        'average_actors_count',
        'subscription_movies_count',
        'purchase_movies_count',
        'movies_by_country',
        'genre_stats',
        'top_keywords',
        'movies_by_year',
    ];

    protected $casts = [
        'movies_by_country' => 'array',
        'genre_stats' => 'array',
        'top_keywords' => 'array',
        'movies_by_year' => 'array',
    ];
}
