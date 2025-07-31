<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController as Team;
use App\Http\Controllers\PlayerController as Player;
use App\Http\Controllers\MathesController as Matches;
use App\Http\Controllers\MatchResultController as MatchResult;
use App\Http\Controllers\ReportController as Report;
use App\Http\Controllers\GoalController as Goal;
use App\Http\Controllers\AuthController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('teams')->group(function () {
        Route::get('/', [Team::class, 'index']);
        Route::get('/{id}', [Team::class, 'show']);
        Route::post('/', [Team::class, 'store']);
        Route::post('/{id}', [Team::class, 'update']);
        Route::delete('/{id}', [Team::class, 'destroy']);
    });

     Route::prefix('players')->group(function () {
        Route::get('/', [Player::class, 'index']);
        Route::get('/{id}', [Player::class, 'show']);
        Route::post('/', [Player::class, 'store']);
        Route::put('/{id}', [Player::class, 'update']);
        Route::delete('/{id}', [Player::class, 'destroy']);
    });

    Route::prefix('matches')->group(function () {
        Route::get('/', [Matches::class, 'index']);
        Route::get('/{id}', [Matches::class, 'show']);
        Route::post('/', [Matches::class, 'store']);
        Route::put('/{id}', [Matches::class, 'update']);
        Route::delete('/{id}', [Matches::class, 'destroy']);
    });

    Route::prefix('result/matches')->group(function () {
        Route::get('/', [MatchResult::class, 'index']);
        Route::get('/{id}', [MatchResult::class, 'show']);
        Route::post('/', [MatchResult::class, 'store']);
        Route::put('/{id}', [MatchResult::class, 'update']);
        Route::delete('/{id}', action: [MatchResult::class, 'destroy']);
    });

    Route::prefix('goals')->group(function () {
        Route::get('/', [Goal::class, 'index']);
        Route::get('/{id}', [Goal::class, 'show']);
        Route::post('/', [Goal::class, 'store']);
        Route::put('/{id}', [Goal::class, 'update']);
        Route::delete('/{id}', action: [Goal::class, 'destroy']);
    });

    Route::prefix('reports')->group(function () {
         Route::get('/', [Report::class, 'index']);
    });
});


