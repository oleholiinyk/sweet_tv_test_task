<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateReportRequest;
use App\Http\Resources\MovieFeedReportResource;
use App\Services\MovieFeedReportService;

class MovieFeedReportController extends Controller
{
    public function __invoke(GenerateReportRequest $request, MovieFeedReportService $service): MovieFeedReportResource
    {
        $report = $service->generate($request->get('max_result'), $request->get('start_index'));

        return MovieFeedReportResource::make($report);
    }
}
