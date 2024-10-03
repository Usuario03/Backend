<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HistoriesController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('resetpassword', 'resetPassword');
    Route::post('logout', 'logout');
    Route::get('dataSesion', 'getAllDataSesion');
});

Route::controller(UserController::class)->group(function () {
    Route::get('user/{id}', 'show');
    Route::put('user/{id}', 'update');
});

Route::controller(NoteController::class)->group(function () {
    Route::get('notes', 'index');
    Route::post('note', 'store');
    Route::get('note/{id}', 'show');
    Route::put('note/{id}', 'update');
    Route::delete('note/{id}', 'destroy');
    Route::get('not', 'ordenarporfechadecreacion');
});

Route::controller(HistoriesController::class)->group(function () {
    Route::get('histories/{id}', 'index');
    Route::post('histories',  'store');
    Route::get('history/{id}', 'show');
    Route::put('history/{id}', 'update');
    Route::delete('history/{id}', 'destroy');
    Route::get('historypatient/{id}', 'historyPatient');
    Route::patch('confirmassistance/{id}', 'confirmAssistance');
});
