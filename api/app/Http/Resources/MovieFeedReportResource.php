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
            $this->resource->id,
            $this->resource->start_index,
            $this->resource->movies_count,
            $this->resource->average_actors_count,
            $this->resource->subscription_movies_count,
            $this->resource->purchase_movies_count,
            $this->resource->movies_by_country,
            $this->resource->genre_stats,
            $this->resource->top_keywords,
            $this->resource->movies_by_year,
        ];
    }
}
