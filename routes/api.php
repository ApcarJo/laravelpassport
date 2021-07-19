<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionController;


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

    //COMMENT CONTROLLER
    Route::post('createcomment', [CommentController::class, 'create']);
    Route::post('partycomments', [CommentController::class, 'index']);
    Route::get('allcomments', [CommentController::class, 'allComments']);
    Route::put('modifycomment', [CommentController::class, 'update']);
    Route::delete('deletecomment', [CommentController::class, 'destroy']);

    //SUBSCRIPTION CONTROLLER
    Route::post('createsubs', [SubscriptionController::class, 'create']);
    Route::get('usersubs', [SubscriptionController::class, 'index']);
    Route::get('allsubs', [SubscriptionController::class, 'allsubs']);
    Route::delete('deletesubs', [SubscriptionController::class, 'destroy']);

    //PARTY CONTROLLER
    Route::post('createparty', [PartyController::class, 'create']);
    Route::post('findparty', [PartyController::class, 'byName']);
    Route::post('selectparty', [PartyController::class, 'partySelector']);
    Route::post('userparty', [PartyController::class, 'byId']);
    Route::get('allparties', [PartyController::class, 'index']);
    Route::get('activeparties', [PartyController::class, 'showActive']);
    Route::put('archiveparty', [PartyController::class, 'archive']);
    Route::delete('deleteparty', [PartyController::class, 'destroy']);
    Route::put('modifyparty', [PartyController::class, 'update']);
    Route::post('gameparties', [PartyController::class, 'allGameParties']);

    //USER CONTROLLER
    Route::get('allusers', [UserController::class, 'index']);
    Route::post('finduser', [UserController::class, 'byName']);
    Route::post('selectuser', [UserController::class, 'userSelector']);
    Route::post('chooseuser', [UserController::class, 'byId']);
    Route::get('activeusers', [UserController::class, 'showActive']);
    Route::put('archiveuser', [UserController::class, 'archive']);
    Route::delete('deleteuser', [UserController::class, 'destroy']);
    Route::put('modifyuser', [UserController::class, 'update']);

    //GAME CONTROLLER
    Route::post('addgame', [GameController::class, 'create']);
    Route::post('findgame', [GameController::class, 'byName']);
    Route::post('selectgame', [GameController::class, 'gameSelector']);
    Route::post('choosegame', [GameController::class, 'byId']);
    Route::get('allgames', [GameController::class, 'index']);
    Route::get('activegames', [GameController::class, 'showActive']);
    Route::put('archivegame', [GameController::class, 'archive']);
    Route::delete('deletegame', [GameController::class, 'destroy']);
    Route::put('modifygame', [GameController::class, 'update']);
});
