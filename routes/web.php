<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MongoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StatisticController;

Route::get('/mongo-data', [MongoController::class, 'getMongoData']);
Route::get('/home', [HomeController::class, 'index']);
Route::get('/statistic', [StatisticController::class, 'index']);
Route::get('/statistic', [StatisticController::class, 'index'])->name('statistic');
Route::get('/fetch-data', [HomeController::class, 'fetchData']);


Route::get('/', function () {
    return view('home');
});
