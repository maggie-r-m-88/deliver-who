<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Spotify\SpotifyAuthController;
use App\Http\Controllers\Spotify\UserPlaylistsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', [TestController::class, 'test'])->middleware('auth.basic');

Route::post('/spotify-auth', [SpotifyAuthController::class, 'authenticate'])->middleware('auth.basic');

Route::post('/playlists', [UserPlaylistsController::class, 'show'])->middleware('auth.basic');

