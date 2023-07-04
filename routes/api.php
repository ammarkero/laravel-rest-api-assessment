<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ExternalDataController;
use App\Http\Controllers\API\RoleController;

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

Route::prefix('v1')->group(function () {
    Route::get('external-data', [ExternalDataController::class, 'retrieve'])->name('external-data.retrieve');
    Route::post('external-data', [ExternalDataController::class, 'store'])->name('external-data.store');
    Route::apiResources([
        'users' => UserController::class,
        'roles' => RoleController::class,
    ]);
});
