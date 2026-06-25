<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Events\MessageSent;

Route::post('/rooms',             [RoomController::class, 'create']);  // buat room
Route::post('/rooms/{code}/join', [RoomController::class, 'join']);    // join room
Route::get ('/rooms/{code}',      [RoomController::class, 'show']); 
Route::patch('/rooms/{code}/settings', [RoomController::class, 'updateSettings']);
Route::delete('/rooms/{code}/leave', [RoomController::class, 'leave']);
Route::post('/rooms/{code}/chat', [RoomController::class, 'chat']);
Route::post('/rooms/{code}/voice-state', [RoomController::class, 'voiceState']);
Route::post('/rooms/{code}/start', [RoomController::class, 'start']);
Route::post('/rooms/{code}/score', [RoomController::class, 'submitScore']);
Route::post('/rooms/{code}/rejoin', [RoomController::class, 'rejoin']);
Route::post('/rooms/{code}/offline', [RoomController::class, 'setOffline']);
Route::post('/rooms/{code}/finish', [RoomController::class, 'finish']);
Route::post('/rooms/{code}/reset', [RoomController::class, 'reset']);