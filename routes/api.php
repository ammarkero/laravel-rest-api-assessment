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

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('auth.logout');
    });

    Route::get('external-data', [ExternalDataController::class, 'retrieve'])->name('external-data.retrieve');
    Route::post('external-data', [ExternalDataController::class, 'store'])->name('external-data.store');

    Route::get('posts/{post}/image', [PostController::class, 'showImage'])->name('posts.show-images');
    Route::post('posts/{post}/image', [PostController::class, 'storeImage'])->name('posts.store-images');

    Route::apiResources([
        'users' => UserController::class,
        'roles' => RoleController::class,
        'users.roles' => RoleUserController::class,
    ]);
});
