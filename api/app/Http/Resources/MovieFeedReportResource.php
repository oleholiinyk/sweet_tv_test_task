<?php

namespace App\Http\Resources;

use App\Models\MovieFeedReport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieFeedReportResource extends JsonResource
{
    /**
     * @var MovieFeedReport
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'max_result' => $this->resource->max_result,
            'start_index' => $this->resource->start_index,
            'movies_count' => $this->resource->movies_count,
            'average_actors_count' => $this->resource->average_actors_count,
            'viewing_options_movies_count' => $this->resource->viewing_options_movies_count,
            'movies_by_country' => $this->resource->movies_by_country,
            'genre_stats' => $this->resource->genre_stats,
            'top_keywords' => $this->resource->top_keywords,
            'movies_by_year' => $this->resource->movies_by_year,
        ];
    }
}
