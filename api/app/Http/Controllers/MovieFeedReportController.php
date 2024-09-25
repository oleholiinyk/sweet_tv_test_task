<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateReportRequest;
use App\Services\MovieFeedReportService;

class MovieFeedReportController extends Controller
{
    public function generate(GenerateReportRequest $request, MovieFeedReportService $service): void
    {
        $service->generate($request->get('max_result'), $request->get('start_index'));
    }
}
