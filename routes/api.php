<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ExternalDataController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\RoleUserController;
use App\Http\Controllers\API\AuthController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->middleware(['throttle:30,1'])->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('auth.logout');
    });

    Route::get('external-data', [ExternalDataController::class, 'retrieve'])->name('external-data.retrieve');
    Route::post('external-data', [ExternalDataController::class, 'store'])->name('external-data.store');

    Route::get('posts/{post}/image', [PostController::class, 'showImage'])->name('posts.show-image');
    Route::post('posts/{post}/image', [PostController::class, 'storeImage'])->name('posts.store-image');

    Route::get('users/{user}/roles', [RoleUserController::class, 'index'])->name('users.roles.index');
    Route::post('users/{user}/roles', [RoleUserController::class, 'store'])->name('users.roles.store');

    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store');

    Route::apiResource('users', UserController::class);
});
