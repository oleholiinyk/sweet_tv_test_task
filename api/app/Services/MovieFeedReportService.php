<?php
declare(strict_types=1);

namespace App\Services;

use App\Contracts\FileReaderProvider;
use App\Models\MovieFeedReport;

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

        dd($rssFeed);

//        foreach ($rssFeed->get_items() as $item) {
//            $newReport = new MovieFeedReport();
//            $newReport->max_result = $maxResult;
//            $newReport->start_index = $startIndex;
//        }

        return $report;
    }
}
