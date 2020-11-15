<?php

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

Route::middleware(['local'])->group(function () {

    ##### Redirect if route not found ####
    Route::fallback(function(){
        return response()->json(responseFormat(__('messages.request_not_found')),\Illuminate\Http\Response::HTTP_NOT_FOUND);
    });

    #### Authentication routes #####
    Route::prefix('auth')->group(function () {
        Route::post('/login', 'AuthController@login')->name('auth.login');
        Route::post('/register', 'AuthController@register')->name('auth.register');
    });

    ################################# Routes for logged user ################################
    Route::middleware(['auth:sanctum'])->group(function () {
        #### Authentication routes #####
        Route::prefix('auth')->group(function () {
            Route::post('/logout', 'AuthController@logout')->name('auth.logout');
        });

        #### Post (tweets) routes #####
        Route::prefix('post')->group(function () {
            Route::post('/store', 'PostController@store')->name('post.store');
        });

        #### Users routes #####
        Route::prefix('user')->group(function () {
            Route::post('/follow', 'UserController@follow')->name('user.follow');
            Route::get('/timeline', 'UserController@timeline')->name('user.timeline');
        });


    });

});
