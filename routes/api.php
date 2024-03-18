<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('bookmarks')
    ->group(function () {
        Route::post('', 'App\Http\Controllers\API\Bookmark\StoreController');
        Route::get('', 'App\Http\Controllers\API\Bookmark\IndexController');
    });
