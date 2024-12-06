<?php

use App\Http\Controllers\API\v1\StatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/v1/status', StatusController::class)->name('api.v1.status');
