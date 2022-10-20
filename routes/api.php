<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'show']);
    });

    Route::group(['prefix' => 'roles'], function() {
        Route::get('/', [RoleController::class, 'index']);
        Route::post('/', [RoleController::class, 'store']);
        Route::get('/{role}', [RoleController::class, 'show']);
        Route::put('/{role}', [RoleController::class, 'update']);
        Route::patch('/', [RoleController::class, 'destroy']);
    });

    Route::group(['prefix' => 'permissions'], function() {
        Route::get('/', [PermissionController::class, 'index']);
        Route::post('/', [PermissionController::class, 'store']);
        Route::get('/{permission}', [PermissionController::class, 'show']);
        Route::put('/{permission}', [PermissionController::class, 'update']);
        Route::patch('/', [PermissionController::class, 'destroy']);
    });

    Route::group(['prefix' => 'categories'], function() {
        Route::get('/', [CategoryController::class, 'index']);
        Route::post('/', [CategoryController::class, 'store']);
        Route::get('/{category}', [CategoryController::class, 'show']);
        Route::put('/{category}', [CategoryController::class, 'update']);
        Route::patch('/', [CategoryController::class, 'destroy']);
    });

    Route::group(['prefix' => 'articles'], function() {
        Route::get('/', [ArticleController::class, 'index']);
        Route::post('/', [ArticleController::class, 'store']);
        Route::get('/{article}', [ArticleController::class, 'show']);
        Route::put('/{article}', [ArticleController::class, 'update']);
        Route::patch('/', [ArticleController::class, 'destroy']);
    });
});
Route::group(['prefix' => 'users'], function() {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{user}', [UserController::class, 'show']);
    Route::put('/{user}', [UserController::class, 'update']);
    Route::patch('/', [UserController::class, 'destroy']);
});
