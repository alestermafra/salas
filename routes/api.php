<?php

use App\Http\Controllers\API\v1\RoomController;
use App\Http\Controllers\API\v1\StatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/v1/status', StatusController::class)->name('api.v1.status');
Route::get('/v1/rooms/{room}', [RoomController::class, 'show'])->name('api.v1.rooms.show');
Route::get('/v1/rooms', [RoomController::class, 'index'])->name('api.v1.rooms.index');
Route::post('/v1/rooms', [RoomController::class, 'store'])->name('api.v1.rooms.store');
Route::put('/v1/rooms/{room}', [RoomController::class, 'update'])->name('api.v1.rooms.update');
