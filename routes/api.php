<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PostController;


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

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {
    Route::resource('posts', PostController::class);
    Route::resource('comments', CommentController::class);
    Route::resource('party', PartyController::class);
    Route::resource('subscriptions', SubscriptionController::class);
    Route::post('addgame', [GameController::class, 'create']);
    Route::get('allgames', [GameController::class, 'index']);
    Route::delete('deletegame', [GameController::class, 'destroy']);
    Route::put('modifygame', [GameController::class, 'update']);
});
