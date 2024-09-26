<?php
declare(strict_types=1);

namespace App\Services;

use App\Contracts\FileReaderProvider;
use App\Models\MovieFeedReport;
use Illuminate\Support\Collection;

readonly class MovieFeedReportService
{
    const string RSS_URL = 'https://sweet.tv/lg/feed/GetContents';

    public function __construct(
        private FileReaderProvider $rssReader,
    )
    {
    }

    public function generate(int $maxResult, int $startIndex)
    {
        $report = MovieFeedReport::query()->where(['max_result' => $maxResult, 'start_index' => $startIndex])->first();

        if ($report) {
            return $report;
        }

        $rssFeed = $this->rssReader->read(self::RSS_URL, ['maxresult' => $maxResult, 'startindex' => $startIndex]);

        return $this->create($rssFeed, $maxResult, $startIndex);
    }

    public function create(Collection $rssFeed, int $maxResult, int $startIndex): MovieFeedReport
    {
        $newReport = new MovieFeedReport();
        $newReport->max_result = $maxResult;
        $newReport->start_index = $startIndex;
        $newReport->movies_count = $rssFeed->count();
        $newReport->countries_count = $this->getTotalCountries($rssFeed);
        $newReport->average_actors_count = $this->getAverageActorsCount($rssFeed);
        $newReport->viewing_options_movies_count = $this->getMoviesCountByViewingOption($rssFeed);
        $newReport->movies_by_country = $this->getMoviesByCountry($rssFeed);
        $newReport->genre_stats = $this->getGenreStats($rssFeed);
        $newReport->top_keywords = $this->getTopKeywords($rssFeed);
        $newReport->movies_by_country = $this->getMoviesByCountry($rssFeed);
        $newReport->movies_by_year = $this->getMoviesByYear($rssFeed);
        $newReport->save();

        return $newReport;
    }

    private function getTotalCountries(Collection $rssFeed): int
    {
        return $rssFeed->pluck('countryavailability')->flatten()->unique()->count();
    }

    private function getAverageActorsCount(Collection $rssFeed): float
    {
        $totalActors = $rssFeed->sum(function ($item) {
            return collect($item['credits'] ?? [])
                ->where('role', 'actor')
                ->count();
        });

        return $rssFeed->count() > 0 ? $totalActors / $rssFeed->count() : 0;
    }

    private function getMoviesCountByViewingOption(Collection $rssFeed): array
    {
        return $rssFeed->flatMap(function ($item) {
            return collect($item['viewingoptions'] ?? [])
                ->groupBy('license')
                ->map(fn($group) => $group->count());
        })->toArray();
    }

    private function getMoviesByCountry(Collection $rssFeed): array
    {
        return $rssFeed->flatMap(function ($item) {
            return collect($item['countryavailability'] ?? []);
        })->countBy()->toArray();
    }


    private function getGenreStats(Collection $rssFeed): array
    {
        return $rssFeed->flatMap(function ($item) {
            return $item['genres'] ?? [];
        })->countBy()->toArray();
    }

    private function getTopKeywords(Collection $rssFeed): array
    {
        $keywords = $rssFeed->flatMap(function ($item) {
            return collect($item['descriptions'] ?? [])
                ->flatMap(fn($description) => preg_split('/[\s,.\-!?]+/', $description))
                ->filter(fn($word) => strlen($word) >= 5)
                ->map(fn($word) => strtolower($word));
        });

        return $keywords->countBy()->sortDesc()->take(15)->toArray();
    }

    private function getMoviesByYear(Collection $rssFeed): array
    {
        return $rssFeed->pluck('videoinfo.makeyear')->countBy()->toArray();
    }
}
