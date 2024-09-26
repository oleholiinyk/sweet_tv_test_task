<?php

use App\Http\Controllers\MovieFeedReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('/movies/feed/reports')->group(function () {
    Route::post('/generate', MovieFeedReportController::class);
});

