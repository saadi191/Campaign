<?php


use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

//Route::group(['middleware' => ['forceHTTPS', 'activity']], function () {


    Route::group(['middleware' => 'auth:sanctum','prefix' => 'admin'], function () {
        Route::get('stat', [AdminController::class, 'stat']);

    });

//});

