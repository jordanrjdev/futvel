<?php

use App\Http\Controllers\LeagueController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::get('/leagues', [LeagueController::class, 'index']);
Route::post('/leagues', [LeagueController::class, 'store']);
Route::get('/league/{id}', [LeagueController::class, 'show']);
Route::put('/league/{id}', [LeagueController::class, 'update']);
Route::delete('/league/{id}', [LeagueController::class, 'destroy']);

Route::get('/teams', [TeamController::class, 'index']);
Route::post('/teams', [TeamController::class, 'store']);
Route::get('/team/{id}', [TeamController::class, 'show']);
Route::put('/team/{id}', [TeamController::class, 'update']);
Route::delete('/team/{id}', [TeamController::class, 'destroy']);
